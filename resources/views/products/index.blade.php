<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        font-size: 30px;
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

    .content h1 {
        font-size: 30px;
        color: #333;
    }

    .content h2 {
        color: #333;
    }

    .content p {
        color: #666;
    }

    .table {
        width: 100%;
        margin-top: 20px;
        text-align: center;
    }

    .search-form {
        margin-bottom: 20px;
    }

    .search-form input[type="text"] {
        width: 300px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .search-form button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-primary {
        margin-top: 20px;
    }
</style>

<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <ul>
            <li><a href="/users">User</a></li>
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
        <h1>Daftar Produk</h1>
        <form action="{{ route('products.index') }}" method="GET">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cari produk..." name="search">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div>
            </div>
        </form>

        @foreach ($products as $product)
            <!-- Tampilkan data produk -->
        @endforeach

        {{ $products->links() }} <!-- Tampilkan pagination jika diperlukan -->


        <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah Produk</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Tipe</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Link</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->type }}</td>
                        <td>{{ $product->price }}</td>
                        <td>
                            <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->name }}" style="max-width: 100px;">
                        </td>
                        <td>{{ $product->link }}</td>
                        <td>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-info">Detail</a>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Anda yakin ingin menghapus produk ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
