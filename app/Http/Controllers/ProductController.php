<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductComment;
use App\Models\ProductLike;

class ProductController extends Controller
{
    private function storeImage($request, $fieldName)
    {
        if ($request->hasFile($fieldName)) {
            $image = $request->file($fieldName);
            $path = $image->store('public/images');
            return Storage::url($path);
        }
        return null;
    }

    public function index(Request $request)
    {
        if ($request->has('search')) {
            return $this->search($request);
        }
    
        $products = Product::paginate(10); // Ganti 10 dengan jumlah item per halaman yang diinginkan
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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required|min:250',
            'type' => 'required|in:t-shirt,hat,jacket,hoodie,pants,shoes',
            'price' => ['required', 'numeric', function ($attribute, $value, $fail) {
                if (strpos($value, 'kata_kunci') !== false) {
                    $fail('Kolom ' . $attribute . ' tidak boleh mengandung kata kunci tertentu.');
                }
            }],
        ]);

        $thumbnail = $this->storeImage($request, 'thumbnail');
        $gambar = $this->storeImage($request, 'gambar');

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'thumbnail' => $thumbnail,
            'gambar' => $gambar,
            'link' => $request->link,
            'price' => $request->price,
        ]);

        return redirect()->route('products.index')->with('success','Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        return view('products.show',compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit',compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required|min:250',
            'type' => 'required|in:t-shirt,hat,jacket,hoodie,pants,shoes',
            'price' => 'required', // Menghapus aturan validasi 'numeric'
        ]);
    
        $product = Product::find($id);
    
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->type = $request->input('type');
    
        // Memeriksa apakah input price adalah numerik
        if (is_numeric($request->input('price'))) {
            $product->price = $request->input('price');
        } else {
            // Jika input price bukan numerik, kembalikan dengan pesan kesalahan
            return redirect()->back()->withErrors(['price' => 'Price harus berupa angka.'])->withInput();
        }
    
        $product->link = $request->input('link');
    
        if ($request->hasFile('thumbnail')) {
            Storage::delete($product->thumbnail);
            $product->thumbnail = $request->file('thumbnail')->store('public/thumbnails');
        }
    
        if ($request->hasFile('gambar')) {
            Storage::delete($product->gambar);
            $product->gambar = $request->file('gambar')->store('public/gambar');
        }
    
        $product->save();
    
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success','Produk berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $products = Product::where('name', 'like', "%$search%")
                            ->orWhere('description', 'like', "%$search%")
                            ->orWhere('type', 'like', "%$search%")
                            ->orWhere('price', 'like', "%$search%")
                            ->paginate(10); // Ganti 10 dengan jumlah item per halaman yang diinginkan
        return view('products.index', compact('products'));
    }
    
    public function comment(Request $request, Product $product)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk membuat komentar.');
        }
         // Validasi input
         $request->validate([
            'content' => 'required|min:5',
        ]);

        // Buat instance komentar
        $comment = new ProductComment();
        $comment->content = $request->content;

        // Tentukan user yang memberikan komentar
        $comment->user_id = auth()->id(); // Jika menggunakan otentikasi pengguna

        // Simpan komentar ke dalam produk yang dimaksud
        $product->comments()->save($comment);

        // Redirect kembali ke halaman produk dengan pesan sukses
        return redirect()->route('products.show', $product)->with('success', 'Komentar berhasil ditambahkan.');
    }
    
    public function like(Product $product)
    {
        if (!auth()->check()) {
            return redirect()->back()->with('error', 'Anda harus masuk untuk menyukai produk.');
        }
    
        $like = new ProductLike(); // Menggunakan model ProductLike
        $like->user_id = auth()->id(); // Jika Anda menggunakan otentikasi pengguna
        $product->likes()->save($like);
    
        return redirect()->back()->with('success', 'Produk disukai.');
    }
}