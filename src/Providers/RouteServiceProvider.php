<?php

namespace TypiCMS\Modules\Downloads\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Downloads\Http\Controllers\Category\AdminController as CategoryAdminController;
use TypiCMS\Modules\Downloads\Http\Controllers\Item\AdminController;
use TypiCMS\Modules\Downloads\Http\Controllers\Category\ApiController as CategoryApiController;
use TypiCMS\Modules\Downloads\Http\Controllers\Item\ApiController;
use TypiCMS\Modules\Downloads\Http\Controllers\PublicController;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        /*
         * Front office routes
         */
        if ($page = TypiCMS::getPageLinkedToModule('downloads')) {
            $middleware = $page->private ? ['public', 'auth'] : ['public'];
            foreach (locales() as $lang) {
                if ($page->isPublished($lang) && $uri = $page->uri($lang)) {
                    Route::middleware($middleware)->prefix($uri)->name($lang.'::')->group(function (Router $router) {
                        $router->get('/', [PublicController::class, 'index'])->name('index-downloads');
                        $router->get('{slug}', [PublicController::class, 'show'])->name('downloads');
                    });
                }
            }
        }

        /*
         * Admin routes
         */
        Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router) {
            $router->get('downloads', [AdminController::class, 'index'])->name('index-downloads')->middleware('can:read downloads');
            $router->get('downloads/export', [AdminController::class, 'export'])->name('admin::export-downloads')->middleware('can:read downloads');
            $router->get('downloads/create', [AdminController::class, 'create'])->name('create-download')->middleware('can:create downloads');
            $router->get('downloads/{download}/edit', [AdminController::class, 'edit'])->name('edit-download')->middleware('can:read downloads');
            $router->post('downloads', [AdminController::class, 'store'])->name('store-download')->middleware('can:create downloads');
            $router->put('downloads/{download}', [AdminController::class, 'update'])->name('update-download')->middleware('can:update downloads');
        });

        /*
         * API routes
         */
        Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router) {
            $router->get('downloads', [ApiController::class, 'index'])->middleware('can:read downloads');
            $router->patch('downloads/{download}', [ApiController::class, 'updatePartial'])->middleware('can:update downloads');
            $router->delete('downloads/{download}', [ApiController::class, 'destroy'])->middleware('can:delete downloads');
        });


        /*
         * Admin routes
         */
        Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router) {
            $router->get('downloadcategories', [CategoryAdminController::class, 'index'])->name('index-downloadcategories')->middleware('can:read downloadcategories');
            $router->get('downloadcategories/export', [CategoryAdminController::class, 'export'])->name('admin::export-downloadcategories')->middleware('can:read downloadcategories');
            $router->get('downloadcategories/create', [CategoryAdminController::class, 'create'])->name('create-downloadcategory')->middleware('can:create downloadcategories');
            $router->get('downloadcategories/{downloadcategory}/edit', [CategoryAdminController::class, 'edit'])->name('edit-downloadcategory')->middleware('can:read downloadcategories');
            $router->post('downloadcategories', [CategoryAdminController::class, 'store'])->name('store-downloadcategory')->middleware('can:create downloadcategories');
            $router->put('downloadcategories/{downloadcategory}', [CategoryAdminController::class, 'update'])->name('update-downloadcategory')->middleware('can:update downloadcategories');
        });

        /*
         * API routes
         */
        Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router) {
            $router->get('downloadcategories', [CategoryApiController::class, 'index'])->middleware('can:read downloadcategories');
            $router->patch('downloadcategories/{downloadcategory}', [CategoryApiController::class, 'updatePartial'])->middleware('can:update downloadcategories');
            $router->delete('downloadcategories/{downloadcategory}', [CategoryApiController::class, 'destroy'])->middleware('can:delete downloadcategories');
        });
    }
}
