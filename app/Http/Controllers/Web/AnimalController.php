<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\Animal\Animal;
use App\Http\Controllers\Controller;

class AnimalController extends Controller
{
   public function index()
    {
        return view('pages.animals.index');
    }

    public function show($slug)
    {
        $animal = Animal::where('slug', $slug)->firstOrFail();

        return view('pages.animals.view', compact('animal'));
    }
}
