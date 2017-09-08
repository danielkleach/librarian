<?php

namespace App\Http\Controllers;

use App\FavoriteBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteBookController extends Controller
{
    protected $favoriteBookModel;

    public function __construct(FavoriteBook $favoriteBookModel)
    {
        $this->favoriteBookModel = $favoriteBookModel;
    }

    public function index()
    {
        $books = $this->favoriteBookModel->with(['user', 'book.category', 'book.author'])
            ->where('user_id', '=', Auth::user()->id)->paginate(20);

        return new IndexFavoriteBookResponse($books);
    }

    public function store(Request $request)
    {
        $book = $this->favoriteBookModel->create([
            'user_id' => Auth::user()->id,
            'book_id' => $request->book_id
        ]);

        return new StoreFavoriteBookResponse($book);
    }

    public function destroy($userId, $favoriteBookId)
    {
        $book = $this->favoriteBookModel->findOrFail($favoriteBookId);
        $this->authorize('destroy', $book);

        $book->delete();

        return new DestroyFavoriteBookResponse($book);
    }
}
