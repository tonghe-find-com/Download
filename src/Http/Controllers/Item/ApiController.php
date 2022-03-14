<?php

namespace TypiCMS\Modules\Downloads\Http\Controllers\Item;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Downloads\Models\Download;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Download::class)
            ->selectFields($request->input('fields.downloads'))
            ->allowedSorts(['status_translated', 'title_translated','position'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(Download $download, Request $request)
    {
        foreach ($request->only('status','position') as $key => $content) {
            if ($download->isTranslatableAttribute($key)) {
                foreach ($content as $lang => $value) {
                    $download->setTranslation($key, $lang, $value);
                }
            } else {
                $download->{$key} = $content;
            }
        }

        $download->save();
    }

    public function destroy(Download $download)
    {
        $download->delete();
    }
}
