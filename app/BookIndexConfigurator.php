<?php

namespace App;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

class BookIndexConfigurator extends IndexConfigurator
{
    use Migratable;

    protected $settings = [
        //
    ];

    protected $defaultMapping = [
        //
    ];
}