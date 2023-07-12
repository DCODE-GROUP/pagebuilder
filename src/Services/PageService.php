<?php

namespace Dcodegroup\PageBuilder\Services;

use Dcodegroup\PageBuilder\Models\Page;
use Dcodegroup\PageBuilder\Models\PageRevision;
use Dcodegroup\PageBuilder\Module;
use Dcodegroup\PageBuilder\Repositories\ModuleRepository;
use Exception;

class PageService
{
    /**
     * @var array
     */
    public const REQUEST_PARAMS = [
        'title',
        'slug',
        'featured_image',
        'featured_image_mobile',
        'parent_id',
        'abstract',
        'content',
        'template_id',
        'active',
    ];

    /**
     * @var array
     */
    public const DIRTY_COMPARISON_PARAMS = [
        'title',
        'abstract',
        'content',
    ];

    /**
     * @var string
     */
    public const PREVIEW_SESSION_KEY = 'page_preview';

    public function __construct(protected ModuleRepository $moduleRepository)
    {
    }

    /**
     * @param  null  $page
     * @return mixed
     */
    public static function save(array $data, $page = null)
    {
        // TODO build validator based on content rules and validate

        // Update and save revision
        if ($page) {
            // TODO fix dirty issue, revisions are always saving as content is always flagging as dirty

            // isDirty() returning false positives, as a workaround we compare arrays
            $current = $page->only(self::DIRTY_COMPARISON_PARAMS);
            //$current['content'] = self::stripSpaces($current['content']);

            $requested = collect($data)->only(self::DIRTY_COMPARISON_PARAMS)->toArray();
            //$requested['content'] = self::stripSpaces($requested['content']);

            if ($current !== $requested) {
                // We only save a revision based on above fields being dirty
                self::saveRevision($page);
            }

            $page->title = $data['title'] ?? $page->title;
            $page->featured_image = $data['featured_image'] ?? null;
            $page->featured_image_mobile = $data['featured_image_mobile'] ?? null;
            $page->parent_id = $data['parent_id'] ?? null;
            $page->abstract = $data['abstract'];
            $page->content = $data['content'];
            $page->user_id = $data['user_id'] ?? $page->user_id;
            $page->slug = $data['slug'] ?? $page->slug;
            $page->template_id = $data['template_id'] ?? $page->template_id;
            $page->active = (isset($data['active']) ? true : false);

            return $page->update();
        }

        // Create page
        return Page::create($data + ['user_id' => auth()->user()->id]);
    }

    public function getPageBySlug(string $slug): ?Page
    {
        if (strstr($slug, '/') && $path = explode('/', $slug)) {
            // Limit to 5 nested TODO validate on save
            if (count($path) > 5) {
                return null;
            }

            // Get first page
            $page = Page::query()->where('slug', array_shift($path))->whereNull('parent_id')->first();

            // Loop over path and fetch each page down the chain
            for ($i = 0; count($path) > $i; $i++) {
                $page = Page::query()->where('slug', $path[$i]);

                if (isset($page->parent_id)) {
                    $page = $page->where('parent_id', $page->parent_id);
                }

                $page = $page->first();
            }

            return $page;
        }

        return Page::query()->where('slug', $slug)->whereNull('parent_id')->first();
    }

    public static function delete(Page $page): bool|null
    {
        return $page->delete();
    }

    public static function persistPreview(Page $page, array $data): void
    {
        session()->flash(self::PREVIEW_SESSION_KEY.$page->id, $data);
    }

    public static function generatePreviewPage(Page $page): mixed
    {
        if (! session()->has(self::PREVIEW_SESSION_KEY.$page->id)) {
            return abort(419);
        }

        $data = session(self::PREVIEW_SESSION_KEY.$page->id);
        $page->title = $data['title'];
        $page->abstract = $data['abstract'];
        $page->content = $data['content'];

        return $page;
    }

    public static function saveRevision(Page $page): void
    {
        PageRevision::create([
            'page_id' => $page->id,
            'title' => $page->title,
            'abstract' => $page->abstract,
            'content' => $page->content,
            'user_id' => $page->user_id,
        ]);
    }

    public static function restoreRevision(PageRevision $revision): void
    {
        $pageData = array_merge($revision->attributesToArray(), $revision->page->attributesToArray());

        // Save and restore revision
        self::save($pageData, $revision->page);

        self::deleteRevision($revision);
    }

    public static function deleteRevision(PageRevision $revision): void
    {
        $revision->delete();
    }

    public function constructPageContent(string $content): string
    {
        try {
            $content = json_decode($content);

            foreach ($content as &$moduleConfig) {
                $data = $this->moduleRepository->buildConfiguration($moduleConfig->module);

                // Merge with default values
                foreach ($data['fields'] as $key => $field) {
                    if (! isset($moduleConfig->fields->{$key})) {
                        $moduleConfig->fields->{$key} = (object) $field;
                    }
                }

                $moduleConfig->templates = $data['templates'];
            }
        } catch (Exception $exception) {
            return '[]';
        }

        return json_encode($content);
    }

    public function render(Page $page, ?array $variables = []): string|null
    {
        if (! $modules = json_decode($page->content)) {
            return null;
        }

        $html = '';

        foreach ($modules as $content) {
            $module = $this->moduleRepository->buildConfiguration($content->name);

            if (! $module) {
                throw new \RuntimeException("Module {$content->name} does not exist.");
            }

            $moduleClass = $module['className'];

            /** @var Module $module */
            $module = new $moduleClass();

            $view = $module->viewName($content->selected_template);
            if (! view()->exists($view)) {
                throw new \RuntimeException("View {$view} does not exist.");
            }

            $templateFields = app()->call([$module, 'fields']);

            $content->fields = (object) array_merge((array) $templateFields, (array) $content->fields);

            $html .= view($view)
                ->with('fields', $content->fields)
                ->with('page', $page)
                ->render();
        }

        foreach ($variables as $key => $value) {
            $html = str_replace($key, $value, $html);
        }

        return $html;
    }

    public static function stripSpaces(string $string): string
    {
        return preg_replace('/\s+/', '', $string);
    }
}
