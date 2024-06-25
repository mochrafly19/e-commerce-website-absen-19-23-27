<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ImageService;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductComment;
use App\Models\ProductLike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->middleware('auth')->only(['comment', 'like']);
    }

    public function index(Request $request)
    {
        if ($request->has('search')) {
            return $this->search($request);
        }

        $products = Product::paginate(10); // Change 10 to the desired number of items per page
        return view('products.index', compact('products'));
    }

    public function welcome()
    {
        $products = Product::all();
        return view('welcome', compact('products'));
    }

    public function home()
    {
        $products = Product::all();
        return view('home', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(StoreProductRequest $request)
    {
        $thumbnail = $request->hasFile('thumbnail') ? $this->imageService->store($request->file('thumbnail')) : null;
        $gambar = $request->hasFile('gambar') ? $this->imageService->store($request->file('gambar')) : null;

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'thumbnail' => $thumbnail,
            'gambar' => $gambar,
            'link' => $request->link,
            'price' => $request->price,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::find($id);

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->type = $request->input('type');

        if (is_numeric($request->input('price'))) {
            $product->price = $request->input('price');
        } else {
            return redirect()->back()->withErrors(['price' => 'Price harus berupa angka.'])->withInput();
        }

        $product->link = $request->input('link');

        if ($request->hasFile('thumbnail')) {
            Storage::delete($product->thumbnail);
            $product->thumbnail = $this->imageService->store($request->file('thumbnail'));
        }

        if ($request->hasFile('gambar')) {
            Storage::delete($product->gambar);
            $product->gambar = $this->imageService->store($request->file('gambar'));
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $products = Product::where('name', 'like', "%$search%")
                            ->orWhere('description', 'like', "%$search%")
                            ->orWhere('type', 'like', "%$search%")
                            ->orWhere('price', 'like', "%$search%")
                            ->paginate(10);
        return view('products.index', compact('products'));
    }

    public function comment(Request $request, Product $product)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk membuat komentar.');
        }

        $request->validate([
            'content' => 'required|min:5',
        ]);

        $comment = new ProductComment();
        $comment->content = $request->content;
        $comment->user_id = Auth::id();

        $product->comments()->save($comment);

        return redirect()->route('products.show', $product)->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function like(Product $product)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Anda harus masuk untuk menyukai produk.');
        }

        $like = new ProductLike();
        $like->user_id = Auth::id();
        $product->likes()->save($like);

        return redirect()->back()->with('success', 'Produk disukai.');
    }
}
