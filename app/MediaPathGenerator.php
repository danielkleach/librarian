<?php

namespace App;

use Spatie\MediaLibrary\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;
use Spatie\MediaLibrary\PathGenerator\BasePathGenerator;

class MediaPathGenerator extends BasePathGenerator implements PathGenerator
{
    /*
     * Get a (unique) base path for the given media.
     */
    protected function getBasePath(Media $media): string
    {
        return 'media/'.$media->getKey();
    }
}
