<?php

namespace App\Http\Controllers;

use App\File;
use App\Download;
use App\DigitalBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookDownloadController extends Controller
{
    protected $digitalBookModel, $fileModel, $downloadModel;

    /**
     * BookDownloadController constructor.
     *
     * @param DigitalBook $digitalBookModel
     * @param File $fileModel
     * @param Download $downloadModel
     */
    public function __construct(
        DigitalBook $digitalBookModel,
        File $fileModel,
        Download $downloadModel
    ){
        $this->digitalBookModel = $digitalBookModel;
        $this->fileModel = $fileModel;
        $this->downloadModel = $downloadModel;
    }

    public function store(Request $request, $bookId)
    {
        $user = Auth::user();
        $book = $this->digitalBookModel->findOrFail($bookId);
        $file = $this->fileModel->where('book_id', $bookId)
            ->where('format', $request->format)
            ->firstOrFail();

        $this->downloadModel->download($user, $book);

        return response()->download($file->path);
    }
}
