<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Courier;

class HomeController extends Controller
{
    public function index()
    {
        $couriers = Courier::all();
        return view('homepage')
        ->with([
            'couriers' => $couriers,
        ]);
    }
}
