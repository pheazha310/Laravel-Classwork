<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::query()
            ->orderBy('id')
            ->get();

        return view('movies.list', compact('movies'));
    }
}
