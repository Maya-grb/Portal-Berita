<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - News Portal</title>
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

    {{-- Navbar --}}
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
            <span class="navbar-brand fw-bold">News Portal Admin</span>
        </div>
    </nav>

    {{-- Sidebar --}}
    <aside class="app-sidebar bg-body-secondary shadow">
        <div class="sidebar-brand p-3 fw-bold">
            News Portal
        </div>
        <div class="sidebar-wrapper">
            <nav class="mt-2">
                <ul class="nav sidebar-menu flex-column">
                    <li class="nav-item">
                        <a href="/admin" class="nav-link">
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/news" class="nav-link">
                            <p>Berita</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    {{-- Konten --}}
    <main class="app-main">
        <div class="app-content p-4">
            @yield('content')
        </div>
    </main>

</div>
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
</body>
</html>