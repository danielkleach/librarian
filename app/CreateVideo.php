<?php

namespace App;

class CreateVideo
{
    protected $videoModel, $actorModel;

    /**
     * CreateVideo constructor.
     *
     * @param Video $videoModel
     * @param Actor $actorModel
     */
    public function __construct(Video $videoModel, Actor $actorModel)
    {
        $this->videoModel = $videoModel;
        $this->actorModel = $actorModel;
    }

    public function handle($request)
    {
        $video = $this->videoModel->create([
            'owner_id' => $request['owner_id'] ?? null,
            'title' => $request['title'],
            'description' => $request['description'],
            'release_date' => $request['release_date'],
            'runtime' => $request['runtime'],
            'thumbnail_path' => $request['thumbnail_path'] ?? null,
            'header_path' => $request['header_path'] ?? null,
            'location' => $request['location'] ?? null
        ]);

        if (isset($request['tags'])) {
            $video->attachTags($request['tags']);
        }

        if (isset($request['actors'])) {
            $this->actorModel->addActors($request['actors'], $video);
        }

        return $video;
    }
}
