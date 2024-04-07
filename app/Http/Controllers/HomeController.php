<?php
  
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Product;
  
class HomeController extends Controller
{
    
    public function search(Request $request)
    {
        $search = $request->input('search');
        $products = Product::where('name', 'like', "%$search%")
                            ->orWhere('description', 'like', "%$search%")
                            ->orWhere('type', 'like', "%$search%")
                            ->orWhere('price', 'like', "%$search%")
                            ->get();
    
        return view('home', compact('products'));
    }
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request): View
    {
        $products = Product::all(); // Mengambil semua produk
    
        if ($request->has('search')) {
            return $this->search($request);
        }
    
        return view('home', compact('products'));
    } 
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome(): View
    {
        return view('adminHome');
    }
}