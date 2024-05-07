<?php

namespace Dcodegroup\PageBuilder\Http\Controllers;

use Dcodegroup\PageBuilder\Services\PageService;

class SiteController
{
    public function __invoke(PageService $pageService, string $slug)
    {
        $slug = '/' . $slug;
        $page = $pageService->getPageBySlug($slug);

        if (! $page) {
            abort(404);
        }

        $templateKey = $page->template?->key ?? 'base';

        return view("page-builder::templates.{$templateKey}", ['page' => $page]);
    }
}
