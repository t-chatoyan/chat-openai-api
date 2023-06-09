<?php

namespace App\Http\Controllers\Api;

use App\Models\Countries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CountriesController extends Controller
{
    public function index()
    {
        try {
            $countries = Countries::all();
            return response()->json([
                'countries' => $countries,
                'status' => true,
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'messages' => $e->getMessage(),
                'status' => false,
            ], 500);
        }

    }
}
