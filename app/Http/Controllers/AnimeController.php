<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'name'      => ['required', 'string'],
            'price'     => ['required', 'integer'],
        ]);

        $anime = Anime::create([
            'name'      => $request->name,
            'price'     => $request->price,
        ]);

        return response()->json([
            'status'    => true,
            'message'   => 'Anime Berhasil Ditambahkan',
            'data'      => $anime,
        ], 201);
    }
}
