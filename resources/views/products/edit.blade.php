<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Sidebar</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

</head>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    /* Sidebar styling */
    .sidebar {
        height: 100%;
        width: 250px;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #ffffff;
        padding-top: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .sidebar h2 {
        color: #ffce00;
        text-align: center;
        margin-bottom: 20px;
    }

    .sidebar ul {
        list-style-type: none;
        padding: 0;
    }

    .sidebar ul li {
        text-align: center;
        margin-bottom: 10px;
    }

    .sidebar ul li a {
        color: #333;
        text-decoration: none;
        display: block;
        padding: 10px;
        transition: background-color 0.3s ease;
    }

    .sidebar ul li a:hover {
        background-color: #f0f0f0;
    }

    .user-info {
        margin-top: 550px;
        padding: 0 20px;
        text-align: center;

    }

    .user-info p {
        margin: 0;
        font-size: 14px;
    }

    .user-info a {
        color: #ffce00;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .user-info a:hover {
        color: #ffd842;
    }

    .user-info button {
        background-color: #ffce00;
        border: none;
        color: #333;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .user-info button:hover {
        background-color: #ffd842;
        color: #fff;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 120px;
        /* Sesuaikan dengan lebar yang diinginkan */
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        z-index: 1;
        text-align: center;
        margin-left: 38px;

    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: center;
    }

    .dropdown-content a:hover {
        background-color: #ddd;
    }

    .show {
        display: block;
        text-align: center;
    }

    /* Content styling */
    .content {
        margin-left: 250px;
        padding: 20px;
    }

    .content h2 {
        color: #333;
    }

    .content p {
        color: #666;
    }

    .table-bordered {
        margin-top: 20px;
        text-align: center;
    }
</style>

<body>
    <div class="sidebar">
        <h2>Sidebar</h2>
        <ul>
            <li><a href="#">User</a></li>
            <li><a href="/products">Product</a></li>
        </ul>
        <!-- Tambahkan login/logout dan nama pengguna -->
        @guest <!-- Cek apakah pengguna belum login -->
            <div class="user-info">
                <p>Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a></p>
                <p>Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
            </div>
        @else
            <!-- Jika pengguna sudah login -->
            <div class="user-info">
                <div class="dropdown">
                    <p onclick="toggleDropdown()" class="dropbtn">Hii,{{ Auth::user()->name }} &#9662;</p>
                    <div id="myDropdown" class="dropdown-content">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </div>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        @endguest
    </div>
    <div class="content">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container">
            <h1>Perbarui Produk</h1>
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nama Produk:</label>
                    <input type="text" id="name" name="name" value="{{ $product->name }}" required>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi:</label>
                    <textarea id="description" name="description" required>{{ $product->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="type">Tipe:</label>
                    <input type="text" id="type" name="type" value="{{ $product->type }}" required>
                </div>
                <div class="form-group">
                    <label for="price">Harga:</label>
                    <input type="text" id="price" name="price" value="{{ $product->price }}" required>
                </div>
                <div class="form-group">
                    <label for="thumbnail">Thumbnail:</label>
                    <input type="file" id="thumbnail" name="thumbnail">
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar:</label>
                    <input type="file" id="gambar" name="gambar">
                </div>
                <div class="form-group">
                    <label for="link">Link:</label>
                    <input type="text" id="link" name="link" value="{{ $product->link }}">
                </div>
                <div class="form-group">
                    <label for="category">Kategori:</label>
                    <select id="category" name="category" required>
                        <option value="T-Shirt" {{ $product->category == 'T-Shirt' ? 'selected' : '' }}>T-Shirt
                        </option>
                        <option value="Hat" {{ $product->category == 'Hat' ? 'selected' : '' }}>Hat</option>
                        <option value="Jacket" {{ $product->category == 'Jacket' ? 'selected' : '' }}>Jacket</option>
                        <option value="Hoodie" {{ $product->category == 'Hoodie' ? 'selected' : '' }}>Hoodie</option>
                        <option value="Pants" {{ $product->category == 'Pants' ? 'selected' : '' }}>Pants</option>
                        <option value="Shoes" {{ $product->category == 'Shoes' ? 'selected' : '' }}>Shoes</option>
                    </select>
                </div>
                <button type="submit">Perbarui</button>
            </form>

        </div>

</body>

</html>
