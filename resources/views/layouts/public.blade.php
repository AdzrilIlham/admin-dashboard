<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'My Portfolio' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">Adzril Portfolio</a>
            <div>
                <a href="/about" class="mx-2">About</a>
                <a href="/portfolio" class="mx-2">Projects</a>
                <a href="/contact" class="mx-2">Contact</a>
            </div>
        </div>
    </nav>

    <main class="py-5">
        @yield('content')
    </main>

    <footer class="text-center py-3 text-muted">
        © {{ date('Y') }} Adzril Ilham Ramadhan
    </footer>
</body>
</html>
