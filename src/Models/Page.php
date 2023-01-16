<?php

namespace Dcodegroup\PageBuilder\Models;

use Dcodegroup\PageBuilder\Models\Seo;
use Dcodegroup\PageBuilder\Services\PageService;
use Dcodegroup\PageBuilder\Traits\CMSMenuResource;
use Dcodegroup\PageBuilder\Traits\DatesForHumans;
use Dcodegroup\PageBuilder\Traits\ScopeActive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use CMSMenuResource;
    use DatesForHumans;
    use ScopeActive;
    use SoftDeletes;

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

    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    /**
     * @return string
     */
    public function getRelativeSlugAttribute()
    {
        return $this->isDynamic ? route($this->route, [], false) : '/'.$this->slug;
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
     * @return bool
     */
    public function getIsDynamicAttribute()
    {
        return isset($this->route);
    }

    /**
     * @return mixed
     */
    public function getDynamicPageContentAttribute()
    {
        return json_decode($this->dynamic_content);
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
