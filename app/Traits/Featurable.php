<?php

namespace App\Traits;

trait Featurable
{
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function feature()
    {
        $this->featured = 1;
        $this->save();
    }
}
