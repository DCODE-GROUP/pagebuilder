<?php

namespace Dcodegroup\PageBuilder;

use Collective\Html\FormBuilder;
use Dcodegroup\PageBuilder\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;
use Dcodegroup\PageBuilder\Http\Controllers\Admin\PageController;
use Dcodegroup\PageBuilder\Http\Controllers\Admin\PageRevisionController;
use Illuminate\Support\Facades\Route;

class PageBuilderServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishConfigs();
            $this->publishMigrations();
        }

        $this->registerRoutes();
        $this->registerViews();
        $this->registerMacros();
    }

    private function publishConfigs()
    {
        $this->publishes([
            __DIR__.'/../config/page-builder.php' => config_path('page-builder.php'),
        ], 'config');
    }

    private function publishMigrations()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/create_menus_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_menus_table.php'),
            __DIR__ . '/../database/migrations/create_menu_items_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()+1) . '_create_menu_items_table.php'),
            __DIR__ . '/../database/migrations/create_templates_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()-1) . '_create_templates_table.php'),
            __DIR__ . '/../database/migrations/create_pages_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_pages_table.php'),
            __DIR__ . '/../database/migrations/create_page_revisions_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()+1) . '_create_page_revisions_table.php'),
        ], 'migrations');
    }

    private function registerRoutes()
    {
        Route::macro('pageBuilder', function (
            string $prefix = 'pages',
            string $name = 'pages',
        ) {
            Route::resource($prefix, PageController::class)->except('show');

            Route::get("$prefix/{page}/preview", [
                PageController::class,
                'preview',
            ])->name("$name.preview");

            Route::put("$prefix/{page}/preview", [
                PageController::class,
                'updatePreview',
            ])->name("$name.preview.update");

            Route::get("$prefix/{page}/revisions", [
                PageRevisionController::class,
                'index',
            ])->name("$name.revisions.index");

            Route::put("$prefix/revisions/{revision}", [
                PageRevisionController::class,
                'restore',
            ])->name("$name.revisions.restore");

            Route::delete("$prefix/revisions/{revision}", [
                PageRevisionController::class,
                'destroy',
            ])->name("$name.revisions.destroy");
        });

        Route::macro('cms', function () {
            Route::get('/{slug}', SiteController::class)->name('cms.view');
        });
    }

    private function registerViews()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'page-builder');
    }

    private function registerMacros()
    {
        FormBuilder::macro('vSelect', function ($name, $class, $selected = null, $attributes = [],
                                                $method = 'getSelectOptions') {
            $method = $method ?? 'getSelectOptions';

            $a = '';
            foreach ($attributes as $attribute => $value) {
                $a .= $attribute.'="'.$value.'" ';
            }

            if (! method_exists($class, $method)) {
                return 'To use vSelect, return an array of options from '.$class.'::'.$method.'($model) or use the vSelectOptions trait';
            }

            return new HtmlString('<selector name="'.$name.'" initial="'.$selected.'" :options=\''.json_encode(call_user_func($class.'::'.$method, $this->model)).'\' '.$a.'/>');
        });
    }
}
