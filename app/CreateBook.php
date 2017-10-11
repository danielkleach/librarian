<?php

namespace App;

class CreateBook
{
    protected $bookModel, $authorModel;

    /**
     * CreateBook constructor.
     *
     * @param Book $bookModel
     * @param Author $authorModel
     */
    public function __construct(Book $bookModel, Author $authorModel)
    {
        $this->bookModel = $bookModel;
        $this->authorModel = $authorModel;
    }

    public function handle($request)
    {
        $book = $this->bookModel->create([
            'category_id' => $request['category_id'] ?? null,
            'owner_id' => $request['owner_id'] ?? null,
            'title' => $request['title'],
            'description' => $request['description'],
            'isbn' => $request['isbn'],
            'publication_year' => $request['publication_year'],
            'location' => $request['location'] ?? null,
            'cover_image_url' => $request['cover_image_url'] ?? null
        ]);

        if (isset($request['tags'])) {
            $book->attachTags($request['tags']);
        }

        if (isset($request['authors'])) {
            $this->authorModel->addAuthors($request['authors'], $book);
        }

        return $book;
    }
}
