<?php

namespace Dcodegroup\PageBuilder\Http\Controllers;

use Dcodegroup\PageBuilder\Services\MenuService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(): View
    {
        return view('admin.cms.menus.index')->with('menuLocations', MenuService::MENU_LOCATIONS);
    }

    public function edit(string $menuLocation): View
    {
        $resources = MenuService::resources();

        $menuLocationLabel = MenuService::MENU_LOCATIONS[$menuLocation]['label'];
        $menuData = MenuService::getStructuredMenu('getTreeStructuredItem', $menuLocation);
        $menu = $menuData->toJson();

        return view('admin.cms.menus.edit', compact('site', 'menuLocationLabel', 'menu', 'resources'));
    }

    public function save(Request $request, string $menuLocation): RedirectResponse
    {
        MenuService::saveMenuAtSiteLocation(json_decode($request->menu), $menuLocation);

        return back()->with('status', 'Menu updated');
    }
}
