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
            'owner_id' => $request['owner_id'] ?? null,
            'title' => $request['title'],
            'description' => $request['description'],
            'isbn' => $request['isbn'],
            'publication_year' => $request['publication_year'],
            'location' => $request['location'] ?? null
        ]);

        if (isset($request['tags'])) {
            $book->attachTags($request['tags']);
        }

        collect($request['authors'])->each(function($authorName) use ($book) {
            $author = $this->authorModel->firstOrCreate(['name' => $authorName]);
            $book->authors()->attach($author);
        });

        return $book;
    }
}
