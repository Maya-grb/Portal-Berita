<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>News Portal</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">News Portal</a>
        </div>
    </nav>

    {{-- Konten --}}
    <div class="container mt-4">
        @yield('content')
    </div>

    {{-- Footer --}}
    <footer class="bg-dark text-white text-center p-3 mt-5">
        <p>&copy; 2026 News Portal</p>
    </footer>

    <script src="{{ asset('js/scripts.js') }}"></script>

</body>
</html>
