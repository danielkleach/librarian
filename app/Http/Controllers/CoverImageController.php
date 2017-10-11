<?php

namespace App\Http\Controllers;

use App\EntityFactory;
use App\Http\Requests\CoverImageRequest;
use App\Http\Responses\CoverImages\StoreCoverImageResponse;
use App\Http\Responses\CoverImages\DestroyCoverImageResponse;

class CoverImageController extends Controller
{
    protected $entityFactory;

    /**
     * CoverImageController constructor.
     *
     * @param EntityFactory $entityFactory
     */
    public function __construct(EntityFactory $entityFactory)
    {
        $this->entityFactory = $entityFactory;
    }

    public function store(CoverImageRequest $request, $itemType, $itemId)
    {
        $entity = $this->entityFactory->translate($itemType);
        $item = $entity->find($itemId);

        $coverImage = $item->coverImage->save($request->cover_image);

        return new StoreCoverImageResponse($coverImage);
    }

    public function destroy($itemType, $itemId)
    {
        $entity = $this->entityFactory->translate($itemType);
        $item = $entity->find($itemId);

        $coverImage = $item->coverImage->delete();

        return new DestroyCoverImageResponse($coverImage);
    }
}
