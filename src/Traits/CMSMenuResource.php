<?php

namespace Dcodegroup\PageBuilder\Traits;

trait CMSMenuResource
{
    /**
     * @return string
     */
    public function getUrlAttribute()
    {
        return $this->slug;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getLabelAttribute($value)
    {
        if (isset($this->title)) {
            return $this->title;
        }

        if (isset($this->name)) {
            return $this->name;
        }

        return $value;
    }
}
