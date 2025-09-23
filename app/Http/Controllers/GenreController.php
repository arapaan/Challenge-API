<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function __invoke(Request $request)
    {
        // dd($request->all());
        // dd(file_get_contents('php://input')); 
        $request->validate([
            'name' => ['required', 'string'],
        ]);

        $genre = Genre::create([
            'name'  => $request->name,
        ]);

        return response()->json([
            'status'    => true,
            'message'   => 'Genre behasil ditambahkan',
            'data'      => $genre,
        ], 201);
    }
}
