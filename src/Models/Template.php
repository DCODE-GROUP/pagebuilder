<?php

namespace Dcodegroup\PageBuilder\Models;

use Dcodegroup\PageBuilder\Services\MacroService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return array
     */
    public static function getSelectOptions()
    {
        return MacroService::constructSelectOptions(Template::all(), 'id', 'name');
    }
}
