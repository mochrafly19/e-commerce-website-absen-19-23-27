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

    .content h1 {
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        color: #333;
        font-weight: bold;
    }

    input[type="text"],
    textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    input[type="file"] {
        padding: 5px 0;
    }

    button[type="submit"] {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
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
    <div class="container">
    <h1>Create a New Product</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" id="description" rows="5">{{ old('description') }}</textarea>
            @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="type">Type</label>
            <select name="type" class="form-control" id="type">
                <option value="">Select Type</option>
                <option value="t-shirt" {{ old('type') == 't-shirt' ? 'selected' : '' }}>T-Shirt</option>
                <option value="hat" {{ old('type') == 'hat' ? 'selected' : '' }}>Hat</option>
                <option value="jacket" {{ old('type') == 'jacket' ? 'selected' : '' }}>Jacket</option>
                <option value="hoodie" {{ old('type') == 'hoodie' ? 'selected' : '' }}>Hoodie</option>
                <option value="pants" {{ old('type') == 'pants' ? 'selected' : '' }}>Pants</option>
                <option value="shoes" {{ old('type') == 'shoes' ? 'selected' : '' }}>Shoes</option>
            </select>
            @error('type')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" name="price" class="form-control" id="price" value="{{ old('price') }}">
            @error('price')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="link">Product Link</label>
            <input type="text" name="link" class="form-control" id="link" value="{{ old('link') }}">
            @error('link')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="thumbnail">Thumbnail Image</label>
            <input type="file" name="thumbnail" class="form-control-file" id="thumbnail">
            @error('thumbnail')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="gambar">Product Image</label>
            <input type="file" name="gambar" class="form-control-file" id="gambar">
            @error('gambar')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Create Product</button>
    </form>
</div>

</body>

</html>
