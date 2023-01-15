<?php

namespace Dcodegroup\PageBuilder\Services;

use Dcodegroup\PageBuilder\Models\Page;
use Dcodegroup\PageBuilder\Models\PageRevision;
use Dcodegroup\PageBuilder\Repositories\ModuleRepository;
use Exception;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;

class PageService
{
    /**
     * List any dynamic pages here from our routes
     * Dynamic pages are not CMS generated but are provided as fixed routes
     *
     * @var array
     */
    public const DYNAMIC_PAGES = [
        //
    ];

    /**
     * List dynamic page routes that can be edited in CMS
     *
     * @var array
     */
    public const EDITABLE_DYNAMIC_PAGES = [
        //
    ];

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
        'dynamic_content',
        'site_id',
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
        'dynamic_content',
    ];

    /**
     * @var string
     */
    public const PREVIEW_SESSION_KEY = 'page_preview';

    /**
     * @param  array  $data
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
            $page->dynamic_content = $data['dynamic_content'];
            $page->user_id = $data['user_id'] ?? $page->user_id;
            $page->slug = $data['slug'] ?? $page->slug;
            $page->site_id = $data['site_id'] ?? $page->site_id;
            $page->template_id = $data['template_id'] ?? $page->template_id;
            $page->active = $page->isDynamic ? true : (isset($data['active']) ? true : false);

            return $page->update();
        }

        // Create page
        return Page::create($data + ['user_id' => auth()->user()->id]);
    }

    /**
     * @param  string  $slug
     * @return mixed
     */
    public static function getPageBySlug(string $slug)
    {
        if (strstr($slug, '/') && $path = explode('/', $slug)) {
            // Limit to 5 nested TODO validate on save
            if (count($path) > 5) {
                return null;
            }

            // Get first page
            $page = Page::where('slug', array_shift($path))->whereNull('parent_id')->first();

            // Loop over path and fetch each page down the chain
            for ($i = 0; count($path) > $i; $i++) {
                $page = Page::where('slug', $path[$i]);

                if (isset($page->parent_id)) {
                    $page = $page->where('parent_id', $page->parent_id);
                }

                if (count($path) === $i) {
                    $page = $page->with('site');
                }

                $page = $page->first();
            }

            return $page;
        }

        return Page::where('slug', $slug)->whereNull('parent_id')->with('site')->first();
    }

    /**
     * @param  Page  $page
     * @return bool|null
     *
     * @throws \Exception
     */
    public static function delete(Page $page)
    {
        return $page->delete();
    }

    /**
     * @param  Page  $page
     * @param  array  $data
     */
    public static function persistPreview(Page $page, array $data)
    {
        session()->flash(self::PREVIEW_SESSION_KEY.$page->id, $data);
    }

    /**
     * @param  Page  $page
     * @return null
     */
    public static function generatePreviewPage(Page $page)
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

    /**
     * @param  Page  $page
     */
    public static function saveRevision(Page $page)
    {
        PageRevision::create([
            'page_id' => $page->id,
            'title' => $page->title,
            'abstract' => $page->abstract,
            'content' => $page->content,
            'user_id' => $page->user_id,
        ]);
    }

    /**
     * @param  PageRevision  $revision
     *
     * @throws \Exception
     */
    public static function restoreRevision(PageRevision $revision)
    {
        $pageData = array_merge($revision->attributesToArray(), $revision->page->attributesToArray());

        // Save and restore revision
        self::save($pageData, $revision->page);

        self::deleteRevision($revision);
    }

    /**
     * @param  PageRevision  $revision
     *
     * @throws \Exception
     */
    public static function deleteRevision(PageRevision $revision)
    {
        $revision->delete();
    }

    /**
     * @param  array  $source
     * @param  bool  $json
     * @return false|string
     */
    public static function getModules($source, $json = true)
    {
        $modules = [];

        foreach ($source as $class) {
            try {
                $modules[(new ReflectionClass($class))->getShortName()] = call_user_func($class.'::module');
            } catch (ReflectionException $exception) {
                continue;
            }
        }

        return $json ? json_encode($modules) : $modules;
    }

    /**
     * @param  string  $content
     * @return string
     */
    public static function constructPageContent(string $content)
    {
        $moduleRepository = resolve(ModuleRepository::class);

        try {
            $content = json_decode($content);

            foreach ($content as &$m) {
                $module = $moduleRepository->findByName($m->module);
                $d = call_user_func($module.'::template');
                foreach ($d['fields'] as $key => $field) {
                    if (! isset($m->fields->{$key})) {
                        $m->fields->{$key} = (object) $field;
                    }
                }
            }
        } catch (Exception $exception) {
            return '[]';
        }

        return json_encode($content);
    }

    /**
     * @param  Page  $page
     * @return |null
     */
    public static function getDynamicPageModules(Page $page)
    {
        if (! isset($page->route) || ! ($d = collect(self::DYNAMIC_PAGES)->where('route', $page->route)
                                                                         ->first()) || ! isset($d['modules'])) {
            return null;
        }

        $c = json_decode($page->dynamic_content);

        return collect(self::getModules($d['modules'], false))->map(function ($module, $class) use ($c) {
            $module['module'] = $class;
            $module['id'] = (string) Str::uuid();

            foreach ($module['fields'] as $key => &$field) {
                $field['value'] = $c->{$class}->fields->{$key}->value ?? $field['value'];
            }

            return $module;
        })->toJson();
    }

    /**
     * @param  Page  $page
     * @return string
     *
     * @throws \Throwable
     */
    public static function render(Page $page)
    {
        if (! $modules = json_decode($page->content)) {
            return null;
        }

        $html = '';

        foreach ($modules as $content) {
            $template = call_user_func('App\Services\CMS\Modules\\'.$content->module.'::template');

            if (($view = 'cms.modules.'.Str::kebab($content->module)) && ! view()->exists($view)) {
                $html .= '<p>View '.$view.' does not exist.</p>';

                continue;
            }

            $templateFields = json_decode(json_encode($template['fields']));
            if ($content->module == 'ProjectSlider') {
                $contentArray = (array) $content->fields;
                $templateArray = (array) $templateFields;

                $merge = array_merge($templateArray, $contentArray);
                $merge['items'] = $templateArray['items'];
                $content->fields = (object) $merge;
            } else {
                $content->fields = (object) array_merge((array) $templateFields, (array) $content->fields);
            }

            $html .= view($view)->with('fields', $content->fields)->render();
        }

        return $html;
    }

    /**
     * @param  string  $string
     * @return string|string[]|null
     */
    public static function stripSpaces(string $string)
    {
        return preg_replace('/\s+/', '', $string);
    }
}
