<?php

namespace Dcodegroup\PageBuilder\Models;

use Dcodegroup\PageBuilder\Traits\DatesForHumans;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageRevision extends Model
{
    use DatesForHumans;
    use SoftDeletes;

    /**
     * @var array
     */
    protected $guarded = ['id'];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
