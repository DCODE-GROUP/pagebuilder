<?php

namespace Dcodegroup\PageBuilder\Traits;

trait DatesForHumans
{
    /**
     * @return mixed
     */
    public function getDeletedAtForHumansAttribute()
    {
        if (! $d = $this->deleted_at) {
            return null;
        }

        return $d->format('d/m/Y');
    }

    /**
     * @return mixed
     */
    public function getCreatedAtForHumansAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }

    /**
     * @return mixed
     */
    public function getUpdatedAtForHumansAttribute()
    {
        return $this->updated_at->format('d/m/Y');
    }

    /**
     * @return string
     */
    public function getUpdatedByForHumansAttribute()
    {
        if (! isset($this->user)) {
            return $this->updatedAtForHumans;
        }

        return 'by '.$this->user->name."\n ".$this->updated_at->format('d/m/Y \a\t g:ia');
    }
}
