<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\Category as CategoryResource;

class CategoryController extends Controller
{
    protected $categoryModel;

    public function __construct(Category $categoryModel)
    {
        $this->categoryModel = $categoryModel;
    }

    public function index()
    {
        return new CategoryResource($this->categoryModel->paginate(25));
    }

    public function show($categoryId)
    {
        return new CategoryResource($this->categoryModel->with('books.category')->findOrFail($categoryId));
    }

    public function store(CategoryRequest $request)
    {
        return new CategoryResource($this->categoryModel->create($request->all()));
    }

    public function update(CategoryRequest $request, $categoryId)
    {
        $category = $this->categoryModel->find($categoryId);
        $category->update($request->all());

        return new CategoryResource($category);
    }
}
