<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') — Portal Kelas XI RPL</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
    <a class="skip-link" href="#konten">Lewati ke konten</a>
    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="{{ route('dashboard') }}">Portal Kelas XI RPL<span>SMK PESAT</span></a>
            <nav aria-label="Navigasi utama">
                <a class="dashboard-link" href="{{ route('dashboard') }}">Kembali ke dashboard</a>
            </nav>
        </div>
    </header>
    <main id="konten" class="container" tabindex="-1">
        @yield('content')
    </main>
    <footer class="container site-footer">XI RPL · SMK PESAT · Praktik GitHub &amp; Pull Request</footer>
    @stack('scripts')
</body>
</html>
