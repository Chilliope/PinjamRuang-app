<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Pinjam Ruang')</title>
</head>
<body>
    <nav>
        <ul>
            <li>
                <a href="/admin/majors">major</a>
            </li>
            <li>
                <a href="/admin/buildings">buildings</a>
            </li>
        </ul>
    </nav>
    <form action="/logout" method="post">
        @csrf
        @method('post')
        <button onclick="return confirm('logout?')">logout</button>
    </form>
    @yield('content')
</body>
</html>
