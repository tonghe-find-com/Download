<?php

namespace TypiCMS\Modules\Downloads\Http\Controllers\Category;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Downloads\Models\Downloadcategory;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Downloadcategory::class)
            ->selectFields($request->input('fields.downloadcategories'))
            ->allowedSorts(['status_translated', 'title_translated','position'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(Downloadcategory $downloadcategory, Request $request)
    {
        foreach ($request->only('status','position') as $key => $content) {
            if ($downloadcategory->isTranslatableAttribute($key)) {
                foreach ($content as $lang => $value) {
                    $downloadcategory->setTranslation($key, $lang, $value);
                }
            } else {
                $downloadcategory->{$key} = $content;
            }
        }

        $downloadcategory->save();
    }

    public function destroy(Downloadcategory $downloadcategory)
    {
        if(count($downloadcategory->child)>0){
            return response(['message' => 'This item cannot be deleted because it has children.'], 403);
        }else{
            $downloadcategory->delete();
        }

    }
}
