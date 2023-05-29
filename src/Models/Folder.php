<?php

namespace Dcodegroup\PageBuilder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Folder extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $guarded = [];

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class, 'folder_id', 'id')->orderByDesc('created_at');
    }
}
