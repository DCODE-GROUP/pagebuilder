<?php

namespace Dcodegroup\PageBuilder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Folder extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $guarded = [];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Folder::class, 'parent_id', 'id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Folder::class, 'parent_id', 'id')->with('children');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class, 'folder_id', 'id')->orderByDesc('created_at');
    }
}
