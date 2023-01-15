<?php

namespace Dcodegroup\PageBuilder\Traits;

trait ScopeActive
{
    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
