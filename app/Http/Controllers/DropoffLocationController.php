<?php

namespace App\Http\Controllers;

use App\Models\DropoffLocation;
use Illuminate\Http\Request;

class DropoffLocationController extends Controller
{
    public function index()
    {
        $locations = DropoffLocation::orderBy('name')->simplePaginate(20);

        return view ('pages.dropoff-locations.index', compact('locations'));
    }
}
