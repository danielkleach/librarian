<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    protected $guarded = [];

    protected $dates = [
        'checkout_date',
        'due_date',
        'return_date'
    ];
}
