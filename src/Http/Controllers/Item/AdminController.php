<?php

namespace Tonghe\Modules\Downloads\Http\Controllers\Item;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use Tonghe\Modules\Downloads\Exports\Export;
use Tonghe\Modules\Downloads\Http\Requests\FormRequest;
use Tonghe\Modules\Downloads\Models\Download;
use Tonghe\Modules\Downloads\Models\Downloadcategory;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('downloads::admin.item.index');
    }

    public function export(Request $request)
    {
        $filename = date('Y-m-d').' '.config('app.name').' downloads.xlsx';

        return Excel::download(new Export($request), $filename);
    }

    public function create()
    {
        if(count(Downloadcategory::all())==0){
            return redirect()->route('admin::index-downloads')->with('error','請先新增至少一種類別');
        }
        $model = new Download();

        return view('downloads::admin.item.create')
            ->with(compact('model'));
    }

    public function edit(download $download)
    {
        if(count(Downloadcategory::all())==0){
            return redirect()->route('admin::index-downloads')->with('error','請先新增至少一種類別');
        }
        return view('downloads::admin.item.edit')
            ->with(['model' => $download]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $download = Download::create($request->validated());

        return $this->redirect($request, $download);
    }

    public function update(download $download, FormRequest $request): RedirectResponse
    {
        $download->update($request->validated());

        return $this->redirect($request, $download);
    }
}
