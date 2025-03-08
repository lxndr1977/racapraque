<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\Animal\Animal;
use App\Http\Controllers\Controller;

class AdoptionsController extends Controller
{
    public function index()
    {
        return view('pages.adoptions.index');
    }

    public function create($slug)
    {
        $animal = Animal::Adoptables()->where('slug', $slug)->firstOrFail();

        return view('pages.adoptions.create', compact('animal'));
    }
}
