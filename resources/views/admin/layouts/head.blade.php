<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="light dark">
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)">

    <title>@yield('title', 'Admin Panel') - News Portal</title>

    <meta name="description" content="Admin Panel for News Portal">
    <meta name="author" content="News Portal">

    <link rel="preload" href="{{ asset('dist/assets/css/adminlte.css') }}" as="style" />
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}" />

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" media="print"
        onload="this.media='all'">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous">

    <!-- OverlayScrollbars (for sidebar) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous">

    <!-- Summernote CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css">

    <!-- AdminLTE CSS -->
    <link rel="preload" href="{{ asset('assets/css/adminlte.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('assets/css/adminlte.css') }}">

    <!-- Custom Styles -->
    @stack('styles')
</head>
