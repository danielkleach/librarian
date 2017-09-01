<?php

namespace App;

class CoverImage
{
    private $book;
    public $media;

    public function __construct($book)
    {
        $this->book = $book;
        $this->media = $this->book->getFirstMedia('cover_image') ?? new NoCoverImage;
    }

    /**
     * Save the provided file replacing any current cover image.
     *
     * @param $file
     * @return $this
     */
    public function save($file)
    {
        $this->media->delete();
        $this->media = $this->book->addMedia($file)->toMediaCollection('cover_image');

        return $this;
    }

    /**
     * Deletes the media associated with the book.
     */
    public function delete()
    {
        $this->media->delete();
        $this->media = new NoCoverImage();
    }

    /**
     * Get the url of the cover_image media
     *
     * @return mixed
     */
    public function url()
    {
        return $this->media->getUrl();
    }
}

class NoCoverImage
{
    public function getUrl()
    {
        return null;
    }

    public function delete()
    {
        return null;
    }
}
