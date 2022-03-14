<?php

namespace TypiCMS\Modules\Downloads\Http\Controllers\Category;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Downloadcategories\Exports\Export;
use TypiCMS\Modules\Downloads\Http\Requests\CategoryFormRequest;
use TypiCMS\Modules\Downloads\Models\Downloadcategory;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('downloads::admin.category.index');
    }

    public function export(Request $request)
    {
        $filename = date('Y-m-d').' '.config('app.name').' downloadcategories.xlsx';

        return Excel::download(new Export($request), $filename);
    }

    public function create(): View
    {
        $model = new Downloadcategory();

        return view('downloads::admin.category.create')
            ->with(compact('model'));
    }

    public function edit(downloadcategory $downloadcategory): View
    {
        return view('downloads::admin.category.edit')
            ->with(['model' => $downloadcategory]);
    }

    public function store(CategoryFormRequest $request): RedirectResponse
    {
        $downloadcategory = Downloadcategory::create($request->validated());

        return $this->redirect($request, $downloadcategory);
    }

    public function update(downloadcategory $downloadcategory, CategoryFormRequest $request): RedirectResponse
    {
        $downloadcategory->update($request->validated());

        return $this->redirect($request, $downloadcategory);
    }
}
