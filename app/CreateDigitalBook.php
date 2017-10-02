<?php

namespace App;

class CreateDigitalBook
{
    protected $bookModel, $authorModel, $fileModel;

    /**
     * CreateDigitalBook constructor.
     *
     * @param DigitalBook $bookModel
     * @param Author $authorModel
     * @param File $fileModel
     */
    public function __construct(DigitalBook $bookModel, Author $authorModel, File $fileModel)
    {
        $this->bookModel = $bookModel;
        $this->authorModel = $authorModel;
        $this->fileModel = $fileModel;
    }

    public function handle($request)
    {
        $book = $this->bookModel->create([
            'title' => $request['title'],
            'description' => $request['description'],
            'isbn' => $request['isbn'],
            'publication_year' => $request['publication_year'],
            'cover_image_url' => $request['cover_image_url'] ?? null
        ]);

        if (isset($request['tags'])) {
            $book->attachTags($request['tags']);
        }

        if (isset($request['authors'])) {
            $this->authorModel->addAuthors($request['authors'], $book);
        }

        if (isset($request['files'])) {
            $this->fileModel->addFiles($request['files'], $book);
        }

        return $book;
    }
}
