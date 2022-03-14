<?php

namespace TypiCMS\Modules\Downloads\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (!Gate::denies('read downloadcategories')) {
            $view->sidebar->group(__('Download'), function (SidebarGroup $group) {
                $group->id = 'download';
                $group->weight = 27;
                $group->addItem(__('Downloadcategories'), function (SidebarItem $item) {
                    $item->id = 'downloadcategories';
                    $item->icon = config('typicms.downloadcategories.sidebar.icon');
                    $item->weight = config('typicms.downloadcategories.sidebar.weight');
                    $item->route('admin::index-downloadcategories');
                    $item->append('admin::create-downloadcategory');
                });
            });
        }

        if (!Gate::denies('read downloads')) {
            $view->sidebar->group(__('Download'), function (SidebarGroup $group) {
                $group->id = 'download';
                $group->weight = 27;
                $group->addItem(__('Downloads'), function (SidebarItem $item) {
                    $item->id = 'downloads';
                    $item->icon = config('typicms.downloads.sidebar.icon');
                    $item->weight = config('typicms.downloads.sidebar.weight');
                    $item->route('admin::index-downloads');
                    $item->append('admin::create-download');
                });
            });
        }
        return ;
    }
}
