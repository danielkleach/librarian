<?php

namespace App;

use App\Exceptions\InvalidItemTypeException;

class EntityFactory
{
    public function translate($type)
    {
        switch ($type) {
            case 'book':
                return new Book();
            case 'ebook':
                return new Ebook();
            case 'video':
                return new Video();
            default:
                throw new InvalidItemTypeException;
        }
    }
}
