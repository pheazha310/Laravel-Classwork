<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();

        return view('catagories.list', compact('categories'));
    }

    public function create()
    {
        return view('catagories.create');
    }

    public function store()
    {
        Category::create([
            'name' => request()->name,
            'description' => request()->description,
        ]);

        return redirect('/categories');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('catagories.edit', compact('category'));
    }

    public function update($id)
    {
        $category = Category::findOrFail($id);
        $category->update([
            'name' => request()->name,
            'description' => request()->description,
        ]);

        return redirect('/categories');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect('/categories');
    }
}
