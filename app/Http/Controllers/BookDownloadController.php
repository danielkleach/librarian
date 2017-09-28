<?php

namespace App\Http\Controllers;

use App\File;
use App\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookDownloadController extends Controller
{
    protected $fileModel, $downloadModel;

    /**
     * BookDownloadController constructor.
     *
     * @param File $fileModel
     * @param Download $downloadModel
     */
    public function __construct(File $fileModel, Download $downloadModel)
    {
        $this->fileModel = $fileModel;
        $this->downloadModel = $downloadModel;
    }

    public function store(Request $request, $bookId)
    {
        $user = Auth::user();
        $file = $this->fileModel->where('book_id', $bookId)->where('format', $request->format)->firstOrFail();

        $this->downloadModel->download($user, $file->book_id);

        return response()->download($file->path);
    }
}
