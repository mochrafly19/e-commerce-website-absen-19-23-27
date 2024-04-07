<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

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
            width: 250px;
            height: 28px;
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
        <h2>Content Area</h2>
        <p>This is the content area.</p>
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
