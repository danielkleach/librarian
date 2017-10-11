<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Responses\Categories\DestroyCategoryResponse;

class CategoryController extends Controller
{
    protected $categoryModel;

    /**
     * CategoryController constructor.
     *
     * @param Category $categoryModel
     */
    public function __construct(Category $categoryModel)
    {
        $this->categoryModel = $categoryModel;
    }

    public function index()
    {
        $categories = $this->categoryModel->paginate(25);

        return CategoryResource::collection($categories);
    }

    public function show($categoryId)
    {
        $category = $this->categoryModel->with('books', 'ebooks')->findOrFail($categoryId);

        return new CategoryResource($category);
    }

    public function store(CategoryRequest $request)
    {
        $category = $this->categoryModel->create($request->all());

        return new CategoryResource($category);
    }

    public function update(CategoryRequest $request, $categoryId)
    {
        $category = $this->categoryModel->findOrFail($categoryId);
        $category->update($request->all());

        return new CategoryResource($category);
    }
}
