<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Http\Responses\Favorites\DestroyFavoriteResponse;

class FavoriteController extends Controller
{
    protected $favoriteModel;

    /**
     * FavoriteController constructor.
     *
     * @param Favorite $favoriteModel
     */
    public function __construct(Favorite $favoriteModel)
    {
        $this->favoriteModel = $favoriteModel;
    }

    public function destroy($favoriteId)
    {
        $favorite = $this->favoriteModel->findOrFail($favoriteId);

        $favorite->delete();

        return new DestroyFavoriteResponse($favorite);
    }
}
