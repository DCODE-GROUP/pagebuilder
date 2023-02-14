<?php

namespace Dcodegroup\PageBuilder\Http\Controllers\Admin;

use Dcodegroup\PageBuilder\Http\Requests\PageRequest;
use Dcodegroup\PageBuilder\Models\Page;
use Dcodegroup\PageBuilder\Repositories\ModuleRepository;
use Dcodegroup\PageBuilder\Routes;
use Dcodegroup\PageBuilder\Services\PageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PageController extends Controller
{
    public function __construct(protected ModuleRepository $moduleRepository, protected PageService $pageService)
    {
    }

    public function index(Request $request): View
    {
        $query = Page::query();

        // Search filter
        if ($request->filled('search')) {
            $term = '%'.$request->input('search').'%';
            $query->where('title', 'like', $term)
                ->orWhere('abstract', 'like', $term)
                ->orWhere('content', 'like', $term);
        }

        return view('page-builder::pages.index')->with('pages', $query->orderByDesc('created_at')->paginate());
    }

    public function create(): View
    {
        return view('page-builder::pages.edit')
            ->with('page', new Page())
            ->with('CMSModules', $this->moduleRepository->buildConfigurations())
            ->with('pageService', $this->pageService);
    }

    public function store(PageRequest $request): JsonResponse|RedirectResponse
    {
        $page = PageService::save($request->only(PageService::REQUEST_PARAMS));

        if ($request->isJson()) {
            return response()->json([
                'page' => $page,
            ]);
        }

        return redirect()->route(Routes::admin('pages.index'))->with('status', 'Page was successfully created');
    }

    public function preview(Request $request)
    {
        $fakePage = new Page([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'abstract' => $request->input('abstract'),
        ]);

        $templateKey = $page->template?->key ?? 'base';

        return response()->json([
            'page' => view("page-builder::templates.{$templateKey}")
                ->with('page', $fakePage)
                ->render(),
        ]);
    }

    public function updatePreview(Page $page): Response
    {
        PageService::persistPreview($page, request()->only('title', 'abstract', 'content'));

        return response(null, 200);
    }

    public function edit(Page $page): View
    {
        return view('page-builder::pages.edit')
            ->with('page', $page)
            ->with('CMSModules', $this->moduleRepository->buildConfigurations())
            ->with('pageService', $this->pageService)
            ->with('featuredImage', $page->getFirstMedia('featured_image'))
            ->with('mobileFeaturedImage', $page->getFirstMedia('mobile_featured_image'));
    }

    public function update(PageRequest $request, Page $page): RedirectResponse
    {
        PageService::save($request->only(PageService::REQUEST_PARAMS), $page);

        return redirect()->route(Routes::admin('pages.edit'), $page)->with('status', 'Page was successfully updated');
    }

    public function destroy(Page $page): RedirectResponse
    {
        PageService::delete($page);

        return redirect()->route(Routes::admin('pages.index'))->with('status', 'Page was successfully deleted');
    }
}
