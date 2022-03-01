<?php

namespace Tonghe\Modules\Downloads\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Downloadcategories\Models\Downloadcategory;
use Tonghe\Modules\Downloads\Models\Download;

class PublicController extends BasePublicController
{
    public static $ONE_PAGE_SHOW_ITEM_AMOUNT = 16;

    public function index(): View
    {
        $categories = Downloadcategory::published()
                                        ->orderBy('position', 'ASC')
                                        ->get();
        $list = Download::published()
                ->orderBy('position','ASC')
                ->paginate(self::$ONE_PAGE_SHOW_ITEM_AMOUNT);
        $model = null;

        return view('downloads::public.index')
                ->with(compact('categories', 'model', 'list'));
    }

    public function show($slug): View
    {
        $categories = Downloadcategory::published()
                                    ->orderBy('position', 'ASC')
                                    ->get();
        $model = Downloadcategory::published()
                                ->whereSlugIs($slug)
                                ->firstOrFail();
        $list = Download::published()
                        ->where('parent_id',$model->id)
                        ->orderBy('position','ASC')
                        ->paginate(self::$ONE_PAGE_SHOW_ITEM_AMOUNT);

        return view('downloads::public.index')
            ->with(compact('categories', 'model', 'list'));
    }
}
