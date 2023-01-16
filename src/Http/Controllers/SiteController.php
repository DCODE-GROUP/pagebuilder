<?php

namespace Dcodegroup\PageBuilder\Http\Controllers;

use Dcodegroup\PageBuilder\Services\PageService;

class SiteController
{
    public function __invoke(PageService $pageService, string $slug)
    {
        $page = $pageService->getPageBySlug($slug);

        if (! $page) {
            abort(404);
        }

        return view('page-builder::cms.page', ['page' => $page]);
    }
}
