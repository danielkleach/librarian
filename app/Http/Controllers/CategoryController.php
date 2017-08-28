<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryModel;

    public function __construct(Category $categoryModel)
    {
        $this->categoryModel = $categoryModel;
    }

    public function index()
    {
        $categories = $this->categoryModel->paginate(25);

        return new IndexCategoryResponse($categories);
    }

    public function show($categoryId)
    {
        $category = $this->categoryModel->findOrFail($categoryId);

        return new ShowCategoryResponse($category);
    }

    public function store(Request $request)
    {
        $category = $this->categoryModel->create($request->all());

        return new StoreCategoryResponse($category);
    }

    public function update(Request $request, $categoryId)
    {
        $category = $this->categoryModel->findOrFail($categoryId);

        $category->update($request->all());

        return new UpdateCategoryResponse($category);
    }

    public function destroy($categoryId)
    {
        $category = $this->categoryModel->findOrFail($categoryId);

        $category->delete();

        return new DestroyCategoryResponse($category);
    }
}
