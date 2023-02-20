<?php

namespace Dcodegroup\PageBuilder\Http\Controllers;

use Dcodegroup\PageBuilder\Services\PageService;

class SiteController
{
    public function __invoke(PageService $pageService, string $parentSlug, string $slug = null)
    {
        $fullSlug = $slug ? $parentSlug . '/' . $slug : $parentSlug;
        $page = $pageService->getPageBySlug($fullSlug);

        if (! $page) {
            abort(404);
        }

        $templateKey = $page->template?->key ?? 'base';

        return view("page-builder::templates.{$templateKey}", ['page' => $page]);
    }
}
