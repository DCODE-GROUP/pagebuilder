<?php

namespace Dcodegroup\PageBuilder\Services;

use Dcodegroup\PageBuilder\Models\Menu;
use Dcodegroup\PageBuilder\Models\MenuItem;
use Dcodegroup\PageBuilder\Models\Page;
use Illuminate\Database\Eloquent\Model;

class MenuService
{
    /**
     * The locations available to assign menus
     *
     * @var array
     */
    public const MENU_LOCATIONS = [
        //
    ];

    /**
     * Any routes added below will
     * automatically provide a feed of the given class
     *
     * @var array
     */
    public const FEED_PAGES = [
        //
    ];

    /**
     * All the resources provided as drop downs in the menus panel
     *
     * @var array
     */
    public const MENU_RESOURCES = [
        'Feeds' => self::FEED_PAGES,
        'Pages' => Page::class,
    ];

    /**
     * @param $classOrArray
     * @return \Illuminate\Support\Collection | void
     */
    public static function mapResourceOption($classOrArray)
    {
        if (is_array($classOrArray)) {
            $items = collect($classOrArray)->filter(function ($item) {
                return ! array_key_exists('children', $item);
            });

            $childrenItems = collect($classOrArray)->filter(function ($item) {
                return array_key_exists('children', $item);
            });

            $childrenItemsFeed = collect();
            if ($childrenItems->isNotEmpty()) {
                $childrenItems->each(function ($item) use (&$childrenItemsFeed) {
                    if (! is_int($item['count']) && $item['count'] != 'all') {
                        $feed = call_user_func($item['class'].'::'.$item['count']);
                    } else {
                        $feed = call_user_func($item['class'].'::take', $item['count'])->get();
                    }
                    if ($feed) {
                        $feed->each(function ($feedItem) use ($item, &$childrenItemsFeed) {
                            $childrenItemsFeed->push([
                                'code' => $feedItem['id'],
                                'label' => $feedItem['name'],
                                'url' => route('acn.blog.show', $feedItem['slug']),
                                'route' => $item['route'],
                                'class' => $item['class'],
                            ]);
                        });
                    }
                });
            }

            return $childrenItemsFeed->merge($items->map(function ($item) {
                return [
                    'code' => $item['route'],
                    'label' => $item['label'],
                    'url' => ($item['route'] != null ? route($item['route']) : ''),
                    'route' => $item['route'],
                ];
            }));
        }

        return call_user_func($classOrArray.'::get')->map(function ($item) {
            return [
                'code' => $item->id,
                'label' => $item->label,
                'url' => $item->url,
            ];
        });
    }

    public static function resources()
    {
        return collect(self::MENU_RESOURCES)->mapWithKeys(function ($classOrArray, $label) {
            $resource = [
                $label => (object) [
                    'items' => array_values(self::mapResourceOption($classOrArray)->toArray()),
                ],
            ];

            if (is_string($classOrArray)) {
                $resource[$label]->class = $classOrArray;
            }

            return $resource;
        });
    }

    /**
     * @param  int  $siteId
     * @param  string  $menuLocation
     * @return mixed
     */
    public static function getMenuAtSiteLocation(int $siteId, string $menuLocation)
    {
        return Menu::query()->where([
            'site_id' => $siteId,
            'location' => $menuLocation,
        ])->with('items')->first();
    }

    /**
     * @param  string  $structureMethod  getTreeStructuredItem | getViewStructuredItem
     * @param  int  $siteId
     * @param  string  $menuLocation
     * @return \Illuminate\Support\Collection
     */
    public static function getStructuredMenu(string $structureMethod, int $siteId, string $menuLocation)
    {
        if (! ($menu = self::getMenuAtSiteLocation($siteId, $menuLocation)) || ! $items = $menu->items) {
            return collect();
        }

        // TODO this should be a recursive map/walker

        $structured = $items->where('parent', null)->map(function ($parentItem) use ($items, $structureMethod) {
            $item = call_user_func('self::'.$structureMethod, $parentItem);

            if ($structureMethod === 'getViewStructuredItem') {
                self::generateFeedItems($parentItem, $item);
            }

            $item->children = $item->children ?? $items->where('parent', $parentItem->id)->map(function ($childItem) use (
                $items, $structureMethod
            ) {
                $item = call_user_func('self::'.$structureMethod, $childItem);

                if ($structureMethod === 'getViewStructuredItem') {
                    self::generateFeedItems($childItem, $item);
                }

                $item->children = $item->children ?? $items->where('parent', $childItem->id)
                                                           ->map(function ($grandChildItem) use ($structureMethod) {
                                                               return call_user_func('self::'.$structureMethod, $grandChildItem);
                                                           })->flatten()->toArray();

                return $item;
            })->flatten()->toArray();

            return $item;
        });

        return $structured->flatten();
    }

    /**
     * @param $menuItem
     * @param $item
     * @return mixed
     */
    protected static function generateFeedItems($menuItem, &$item)
    {
        if (isset($menuItem->feed_route)) {
            if (($fp = collect(self::FEED_PAGES)->where('route', $menuItem->feed_route)->first())) {
                $isChildFeed = isset($fp['children']) && $fp['children'];

                if (! is_int($fp['count']) && $fp['count'] != 'all') {
                    $feed = call_user_func($fp['class'].'::'.$fp['count']);
                } else {
                    $fp['count'] = $fp['count'] === 'all' ? -1 : $fp['count'];

                    $feed = $isChildFeed ? $menuItem->linkable->{$fp['relation']}()
                                                              ->limit($fp['count']) : call_user_func($fp['class'].'::take', $fp['count']);
                }

                $feed->get()->each(function ($feedItem) use (&$item, $menuItem, $fp, $isChildFeed) {
                    $item->children[] = (object) [
                        'title' => $feedItem->name,
                        'link' => route($fp['show_route'] ?? $fp['route'], $isChildFeed ? [
                            $menuItem->linkable->slug,
                            $feedItem->slug,
                        ] : $feedItem->slug),
                    ];
                });
            }
        }
    }

    /**
     * @param  MenuItem  $menuItem
     * @return object
     */
    protected static function getTreeStructuredItem(MenuItem $menuItem)
    {
        return (object) [
            'id' => $menuItem->id,
            'title' => $menuItem->label,
            'data' => (object) [
                'url' => $menuItem->url,
                'linkable_id' => $menuItem->linkable_id,
                'linkable_type' => $menuItem->linkable_type,
                'feed_route' => $menuItem->feed_route,
                'new_tab' => $menuItem->new_tab,
            ],
        ];
    }

    /**
     * @param  MenuItem  $menuItem
     * @return object
     */
    protected static function getViewStructuredItem(MenuItem $menuItem)
    {
        if (! preg_match('^https?://|\/^', $menuItem->url) && ! str_contains($menuItem->url, 'tel:')) {
            $menuItem->url = '/'.$menuItem->url;
        }

        $url = $menuItem->linkable ? self::getLinkableRouteUrl($menuItem->linkable) : $menuItem->url;

        return (object) [
            'title' => $menuItem->label,
            'link' => $url,
            'new_tab' => $menuItem->new_tab,
        ];
    }

    /**
     * @param  Model  $linkable
     * @return string
     */
    protected static function getLinkableRouteUrl(Model $linkable)
    {
        switch (get_class($linkable)) {
            case Page::class:
                return route('tcs.pages.show', $linkable->slug);
        }
    }

    /**
     * @param  array  $menuData
     * @param  int  $siteId
     * @param  string  $menuLocation
     */
    public static function saveMenuAtSiteLocation(array $menuData, int $siteId, string $menuLocation)
    {
        // Fetch existing menu or create new one
        $menu = Menu::firstOrCreate([
            'site_id' => $siteId,
            'location' => $menuLocation,
        ], [
            'label' => self::MENU_LOCATIONS[$siteId][$menuLocation]['label'],
            'active' => 1,
            'user_id' => auth()->user()->id,
        ]);

        $menuItemIds = [];

        // Loop over menu items and updateOrCreate
        foreach ($menuData as $position => $menuItemData) {
            $menuItem = self::updateOrCreateMenuItem($menuItemData, $menu->id, $position);
            $menuItemIds[] = $menuItem->id;
            self::updateOrCreateMenuItemChildren($menuItemData, $menu->id, $menuItem->id, $menuItemIds);
        }

        // Sync menu items
        $menuData = json_decode(json_encode($menuData), true);

        array_walk_recursive($menuData, function ($value) use (&$menuItemIds) {
            if (is_int($value)) {
                $menuItemIds[] = $value;
            }
        });

        $menu->items()->whereNotIn('id', $menuItemIds)->delete();
    }

    /**
     * @param $menuItemData
     * @param  int  $menuId
     * @param  int  $parentId
     * @param $menuItemIds
     */
    protected static function updateOrCreateMenuItemChildren($menuItemData, int $menuId, int $parentId, &$menuItemIds)
    {
        if (! isset($menuItemData->children)) {
            return;
        }

        foreach ($menuItemData->children as $position => $menuItemChildData) {
            $childMenuItem = self::updateOrCreateMenuItem($menuItemChildData, $menuId, $position, $parentId);
            $menuItemIds[] = $childMenuItem->id;
            self::updateOrCreateMenuItemChildren($menuItemChildData, $menuId, $childMenuItem->id, $menuItemIds);
        }
    }

    /**
     * @param $menuItemData
     * @param  int  $menuId
     * @param  int  $position
     * @param  int|null  $parentId
     * @return mixed
     */
    protected static function updateOrCreateMenuItem($menuItemData, int $menuId, int $position, int $parentId = null)
    {
        return MenuItem::updateOrCreate([
            'menu_id' => $menuId,
            'id' => $menuItemData->id ?? null,
        ], [
            'label' => $menuItemData->title,
            'position' => $position,
            'parent' => $parentId,
            'linkable_id' => $menuItemData->data->linkable_id ?? null,
            'linkable_type' => $menuItemData->data->linkable_type ?? null,
            'feed_route' => $menuItemData->data->feed_route ?? null,
            'url' => $menuItemData->data->url ?? null,
            'new_tab' => $menuItemData->data->new_tab ?? false,
            'user_id' => auth()->user()->id,
        ]);
    }
}
