<?php

namespace App\Http\Controllers;

use App\UserReview;
use Illuminate\Http\Request;

class UserReviewController extends Controller
{
    protected $userReviewModel;

    public function __construct(UserReview $userReviewModel)
    {
        $this->userReviewModel = $userReviewModel;
    }

    public function index()
    {
        $userReviews = $this->userReviewModel->with(['user', 'book'])->paginate(25);

        return new IndexUserReviewResponse($userReviews);
    }

    public function show($userReviewId)
    {
        $userReview = $this->userReviewModel->with(['user', 'book'])->findOrFail($userReviewId);

        return new ShowUserReviewResponse($userReview);
    }

    public function store(Request $request)
    {
        $userReview = $this->userReviewModel->create($request->all());

        return new StoreUserReviewResponse($userReview);
    }

    public function update(Request $request, $userReviewId)
    {
        $userReview = $this->userReviewModel->findOrFail($userReviewId);

        $userReview->update($request->all());

        return new UpdateUserReviewResponse($userReview);
    }

    public function destroy($userReviewId)
    {
        $userReview = $this->userReviewModel->findOrFail($userReviewId);

        $userReview->delete();

        return new DestroyUserReviewResponse($userReview);
    }
}
