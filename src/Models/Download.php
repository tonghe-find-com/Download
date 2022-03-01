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
use TypiCMS\Modules\Downloadcategories\Models\Downloadcategory;

class Download extends Base
{
    use HasFiles;
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected $presenter = ModulePresenter::class;

    protected $dates = ['show_date'];

    protected $guarded = [];

    public $translatable = [
        'title',
        'status',
    ];

    public function getThumbAttribute(): string
    {
        return $this->present()->image(null, 54);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    public function category()
    {
        return $this->belongsTo(Downloadcategory::class,'parent_id');
    }
}
