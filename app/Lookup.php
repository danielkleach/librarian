<?php

namespace App;

use Exception;
use GuzzleHttp\Client;
use App\Exceptions\BookLookupFailureException;

class Lookup
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function handle($data)
    {
        try {
            $response = $this->client->request('GET', 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $data->isbn);
        } catch (Exception $e) {
            throw new BookLookupFailureException;
        }

        $decoded = json_decode($response->getBody()->getContents());

        if ($decoded->totalItems == 0) {
            return (object) [
                'title' => null,
                'description' => null,
                'isbn' => null,
                'publication_year' => null,
                'authors' => null,
                'cover_image_url' => null
            ];
        }

        $data = $decoded->items[0]->volumeInfo;

        return (object) [
            'title' => $data->title,
            'description' => $data->description,
            'isbn' => $data->industryIdentifiers[0]->identifier,
            'publication_year' => (int) date('Y', strtotime($data->publishedDate)),
            'authors' => $data->authors,
            'cover_image_url' => $data->imageLinks->thumbnail
        ];
    }
}