<?php

namespace Dcodegroup\PageBuilder\Traits;

trait ScopeActive
{
    /**
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
