<?php

namespace Tonghe\Modules\Downloads\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Files\Traits\HasFiles;
use TypiCMS\Modules\History\Traits\Historable;
use Tonghe\Modules\Downloads\Presenters\ModulePresenter;
use Tonghe\Modules\Downloads\Models\Download;

class Downloadcategory extends Base
{
    use HasFiles;
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected $presenter = ModulePresenter::class;

    protected $guarded = [];

    public $translatable = [
        'title',
        'slug',
        'status',
        'summary',
        'body',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    public function getThumbAttribute(): string
    {
        return $this->present()->image(null, 54);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    public function allForSelect(): array
    {
        $models = $this->order()
                ->get()
                ->pluck('title', 'id')
                ->all();

        return ['' => ''] + $models;
    }

    public function url()
    {
        return route(app()->getLocale()."::downloads",$this->slug);
    }

    public static function list()
    {
        return self::published()->orderBy('position','ASC')->get();
    }

    public function child()
    {
        return $this->hasMany(Download::class,'parent_id','id')->published()->orderBy('position','ASC');
    }
}
