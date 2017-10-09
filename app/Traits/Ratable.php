<?php

namespace App\Traits;

trait Ratable
{
    public function scopeRecommended($query)
    {
        return $query->orderBy('rating', 'desc');
    }
}
