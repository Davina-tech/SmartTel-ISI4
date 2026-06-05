<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Smartel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 w-64 bg-indigo-700 text-white shadow-lg">
        <div class="p-6 font-bold text-xl">Smartel</div>
        <nav class="mt-6 space-y-2">
            <a href="{{ route('accueil') }}" class="block px-4 py-2 hover:bg-indigo-600">Accueil</a>
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-indigo-600">Dashboard</a>
            <a href="{{ route('sources') }}" class="block px-4 py-2 hover:bg-indigo-600">Sources</a>
            <a href="{{ route('analyses') }}" class="block px-4 py-2 hover:bg-indigo-600">Analyses</a>
            
        </nav>
    </aside>

    <!-- Contenu -->
    <main class="ml-64 p-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="ml-64 p-6 text-center text-gray-500">
        &copy; 2026 Smartel. Tous droits réservés.
    </footer>

</body>
</html>
