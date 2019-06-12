<?php

namespace App;

use Exception;
use GuzzleHttp\Client;
use App\Exceptions\VideoNotFoundException;
use App\Exceptions\VideoLookupFailureException;

class VideoLookup
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search($term)
    {
        try {
            $response = $this->client->request('GET',
                config('settings.tmdb.search_url') . '?api_key=' .
                config('settings.tmdb.api_key') . '&query=' . $term);
        } catch (Exception $e) {
            throw new VideoLookupFailureException();
        }

        $decoded = $this->decode($response);

        if (empty($decoded->results)) {
            throw new VideoNotFoundException;
        }

        $videos = collect($decoded->results)->map(function($video) {
            return (object) [
                'id' => $video->id,
                'title' => $video->title,
                'description' => $video->overview,
                'release_date' => $video->release_date,
                'thumbnail_path' => config('settings.tmdb.images.base_url') . $video->poster_path
            ];
        });

        return $videos;
    }

    public function get($movieId)
    {
        try {
            $response = $this->client->request('GET',
                config('settings.tmdb.get_url') . $movieId . '?api_key=' .
                config('settings.tmdb.api_key'));
        } catch (Exception $e) {
            throw new VideoNotFoundException();
        }

        $video = $this->decode($response);

        return [
            'title' => $video->title,
            'description' => $video->overview,
            'release_date' => $video->release_date,
            'runtime' => $video->runtime,
            'thumbnail_path' => config('settings.tmdb.images.base_url') . $video->poster_path,
            'header_path' => config('settings.tmdb.images.base_url') . $video->backdrop_path
        ];
    }

    public function decode($data)
    {
        return json_decode($data->getBody()->getContents());
    }
}