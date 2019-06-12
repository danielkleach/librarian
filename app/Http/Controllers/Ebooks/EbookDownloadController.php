<?php

namespace App\Http\Controllers\Ebooks;

use App\File;
use App\Ebook;
use App\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class EbookDownloadController extends Controller
{
    protected $eBookModel, $fileModel, $downloadModel;

    /**
     * EbookDownloadController constructor.
     *
     * @param Ebook $eBookModel
     * @param File $fileModel
     * @param Download $downloadModel
     */
    public function __construct(
        Ebook $eBookModel,
        File $fileModel,
        Download $downloadModel
    ){
        $this->eBookModel = $eBookModel;
        $this->fileModel = $fileModel;
        $this->downloadModel = $downloadModel;
    }

    public function store(Request $request, $bookId)
    {
        $user = Auth::user();
        $book = $this->eBookModel->findOrFail($bookId);
        $file = $this->fileModel->where('book_id', $bookId)
            ->where('format', $request->format)
            ->firstOrFail();

        $this->downloadModel->download($user, $book);

        return response()->download($file->path);
    }
}
