<?php

namespace Dcodegroup\PageBuilder\Models;

use Dcodegroup\PageBuilder\Services\PageService;
use Dcodegroup\PageBuilder\Traits\CMSMenuResource;
use Dcodegroup\PageBuilder\Traits\DatesForHumans;
use Dcodegroup\PageBuilder\Traits\ScopeActive;
use Dcodegroup\SeoSettings\Traits\HasSeo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends UsesMedia
{
    use CMSMenuResource;
    use DatesForHumans;
    use ScopeActive;
    use SoftDeletes;
    use HasSeo;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    public function revisions(): HasMany
    {
        return $this->hasMany(PageRevision::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

//    public function seo(): MorphOne
//    {
//        return $this->morphOne(Seo::class, 'seoable');
//    }

    /**
     * @return string
     */
    public function getRelativeSlugAttribute()
    {
        return '/'.$this->slug;
    }

    /**
     * @return string
     */
    public function getStatusAttribute()
    {
        return $this->active ? 'Active' : 'In-active';
    }

    /**
     * @return int
     */
    public function getRevisionsCountAttribute()
    {
        return $this->revisions()->count();
    }

    /**
     * @param  Model|null  $model  The model instantiating the options
     * @return array
     */
    public static function getSelectOptions(Model $model = null)
    {
        $options = [];

        $q = app(static::class)->whereNull('route');

        if (isset($model, $model->id)) {
            $q = $q->where('id', '!=', $model->id);
        }

        $q->get()->each(function ($item) use (&$options) {
            $options[] = [
                'label' => $item->name ?? $item->label ?? $item->title,
                'code' => $item->id,
            ];
        });

        return $options;
    }

    public function render()
    {
        return resolve(PageService::class)->render($this);
    }
}
