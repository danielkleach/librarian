<?php

namespace App\Http\Controllers;

use App\Video;
use App\Http\Requests\SearchRequest;

class VideoSearchController extends Controller
{
    protected $videoModel;

    /**
     * VideoSearchController constructor.
     *
     * @param Video $videoModel
     */
    public function __construct(Video $videoModel)
    {
        $this->videoModel = $videoModel;
    }

    public function index(SearchRequest $request)
    {
        $videos = $this->videoModel->search($request->search)->get();

        return $videos;
    }
}
