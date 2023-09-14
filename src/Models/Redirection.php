<?php

namespace Dcodegroup\PageBuilder\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Redirection
 *
 * @property string $appended_parameters_link
 */
class Redirection extends Model
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'info' => 'array',
    ];

    /**
     * @return LengthAwarePaginator
     */
    public static function getRedirection($searchTerm = null)
    {
        $query = Redirection::query();
        if ($searchTerm) {
            $query->where('from', 'like', "%$searchTerm%")->orWhere('to', 'like', "%$searchTerm%")
                ->orWhere('info', 'like', "%$searchTerm%");
        }

        return $query->paginate(20);
    }

    /**
     * @return mixed|string
     */
    public function getAppendedParametersLinkAttribute()
    {
        if (isset($this->info['qr_code'])) {
            return $this->to.'?qr_code=true';
        }

        if (! empty($this->info)) {
            return $this->to.'?'.http_build_query($this->info);
        }

        return $this->to;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAtForHumansAttribute()
    {
        if (! $this->updated_at) {
            return null;
        }

        return $this->updated_at->format('d/m/Y H:s');
    }
}
