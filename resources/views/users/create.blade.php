<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            margin: 0;
            /* Menghilangkan margin */
            text-align: center;
        }

        .btn-primary {
            background-color: #ffce00;
            border-color: #ffce00;
            /* Jika ingin mengubah warna border juga */
            color: #000;
            /* Mengubah warna teks menjadi hitam */
        }

        .btn-primary:hover {
            background-color: #ffd842;
            /* Jika ingin memberikan efek hover */
        }

        .text-las {
            color: #ffce00
        }
        .col{
            margin-top: 20px;
        }
    </style>
</head>

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
        <h1>Create User</h1>
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number">
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address"></textarea>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-select" id="type" name="type">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>


    </div>

    <script>
        function toggleDropdown() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>

</html>
