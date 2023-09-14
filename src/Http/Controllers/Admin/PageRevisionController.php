<?php

namespace Dcodegroup\PageBuilder\Http\Controllers\Admin;

use Dcodegroup\PageBuilder\Models\Page;
use Dcodegroup\PageBuilder\Models\PageRevision;
use Dcodegroup\PageBuilder\Routes;
use Dcodegroup\PageBuilder\Services\PageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PageRevisionController extends Controller
{
    public function index(Page $page): View
    {
        $revisions = $page->revisions()
            ->latest()
            ->paginate(20);

        return view('page-builder::revisions.index', compact('page', 'revisions'));
    }

    public function show(PageRevision $revision): View
    {
        $page = $revision->page;

        $page->fill($revision->only(['title', 'abstract', 'content']));

        $templateKey = $page->template?->key ?? 'base';

        return view("page-builder::templates.$templateKey", ['page' => $page, 'isRevision' => true]);
    }

    public function restore(PageRevision $revision): RedirectResponse
    {
        PageService::restoreRevision($revision);

        return redirect()->route(Routes::admin('pages.edit'), $revision->page)
                         ->with('status', 'Page revision content was restored');
    }

    public function destroy(PageRevision $revision): RedirectResponse
    {
        PageService::deleteRevision($revision);

        return back()->with('status', 'Page revision was deleted');
    }
}
