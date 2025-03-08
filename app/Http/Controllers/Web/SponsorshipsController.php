<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\Animal\Animal;
use App\Http\Controllers\Controller;

class SponsorshipsController extends Controller
{

    public function index()
    {
        return view('pages.sponsorships.index');
    }

    public function create($slug)
    {
        $animal = Animal::where('slug', $slug)->firstOrFail();

        return view('pages.sponsorships.create', compact('animal'));
    }

}
