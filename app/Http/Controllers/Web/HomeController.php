<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\Animal\Animal;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function show() {

        $adoptables = Animal::query()
            ->orderBy('created_at')
            ->adoptables()
            ->limit(4)
            ->get();

        $sponsorables = Animal::query()
            ->orderBy('created_at')
            ->sponsorables()
            ->limit(4)
            ->get();

        return view('home', compact('adoptables', 'sponsorables'));
    }
}
