<?php

namespace Tonghe\Modules\Downloads\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use Tonghe\Modules\Downloads\Composers\SidebarViewComposer;
use Tonghe\Modules\Downloads\Facades\Downloads;
use Tonghe\Modules\Downloads\Models\Download;
use Tonghe\Modules\Downloads\Models\Downloadcategory;
use Tonghe\Modules\Downloads\Facades\Downloadcategories;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'typicms.downloads');
        $this->mergeConfigFrom(__DIR__.'/../config/permissions.php', 'typicms.permissions');

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['downloads' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(null, 'downloadcategories');
        $this->loadViewsFrom(null, 'downloads');

        //資料庫建置檔案樣本
        $this->publishes([
            __DIR__.'/../database/migrations/create_downloads_table.php.stub' => getMigrationFileName('create_downloads_table'),
        ], 'migrations');

        AliasLoader::getInstance()->alias('Downloads', Downloads::class);
        AliasLoader::getInstance()->alias('Downloadcategories', Downloadcategories::class);

        // Observers
        Downloadcategory::observe(new SlugObserver());

        /*
         * Sidebar view composer
         */
        $this->app->view->composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        $this->app->view->composer('downloads::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('downloads');
        });
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register(RouteServiceProvider::class);

        $app->bind('Downloadcategories', Downloadcategory::class);

        $app->bind('Downloads', Download::class);
    }
}
