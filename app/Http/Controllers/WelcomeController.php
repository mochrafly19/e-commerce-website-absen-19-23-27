<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class WelcomeController extends Controller
{
    public function welcome(Request $request)
    {
        if ($request->has('search')) {
            return $this->search($request);
        }
    
        $products = Product::all();
        return view('welcome', compact('products'));
    }    

    public function search(Request $request)
{
    $search = $request->input('search');
    $products = Product::where('name', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%")
                        ->orWhere('type', 'like', "%$search%")
                        ->orWhere('price', 'like', "%$search%")
                        ->get();
    return view('welcome', compact('products'));
}
}
