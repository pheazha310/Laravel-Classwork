<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatagoriesController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        // dd($categories);
        return view('catagory.list', compact('categories'));
    }

    public function create()
    {
        return view('catagory.create');
    }

    public function store()
    {
        // dd(request()->all());
        Category::create(
            [
                'name' => request()->name,
                'description' => request()->description,
            ]
        );

        // return view('categories.list'); XXXXXX don't do this 
        return redirect('/categories');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        // dd($category);
        return view('catagory.edit', compact('category'));
    }

    public function update($id)
    {
        // dd(request()->all());
        $category = Category::find($id);
        $category->update(
            [
                'name' => request()->name,
                'description' => request()->description,
            ]
        );

        return redirect('/categories');
    }

    public function destroy($id)
    {
        // dd($id);
        $category = Category::find($id);
        $category->delete();
        return redirect('/categories');
    }
}
