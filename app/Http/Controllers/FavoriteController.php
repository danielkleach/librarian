<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\EntityFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Favorite as FavoriteResource;
use App\Http\Responses\Favorites\DestroyFavoriteResponse;

class FavoriteController extends Controller
{
    protected $favoriteModel, $entityFactory;

    /**
     * FavoriteController constructor.
     *
     * @param Favorite $favoriteModel
     * @param EntityFactory $entityFactory
     */
    public function __construct(Favorite $favoriteModel, EntityFactory $entityFactory)
    {
        $this->favoriteModel = $favoriteModel;
        $this->entityFactory = $entityFactory;
    }

    public function store(Request $request, $itemType, $itemId)
    {
        $entity = $this->entityFactory->translate($itemType);
        $item = $entity->find($itemId);

        $favorite = $this->favoriteModel->createFavorite(Auth::user()->id, $item);

        return new FavoriteResource($favorite);
    }

    public function destroy($favoriteId)
    {
        $favorite = $this->favoriteModel->findOrFail($favoriteId);

        $favorite->delete();

        return new DestroyFavoriteResponse($favorite);
    }
}
