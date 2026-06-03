<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Smartel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('smartel.png') }}" alt="Smartel Logo" class="h-12 w-auto drop-shadow-md">
        </div>

        <!-- Titre -->
        <h1 class="text-2xl font-bold text-center text-gray-900 mb-6">Se connecter</h1>

        <!-- Formulaire -->
        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                <input type="email" id="email" name="email" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input type="password" id="password" name="password" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="mr-2 rounded border-gray-300">
                    Se souvenir de moi
                </label>
                <a href="#" class="text-sm text-indigo-600 hover:underline">Mot de passe oublié ?</a>
            </div>

            <button type="submit"
                    class="w-full rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500 transition">
                    <a href="{{ route('dashboard') }}">Se connecter</a>
         
            </button>
        </form>

        <!-- Lien inscription -->
        <p class="mt-6 text-center text-sm text-gray-600">
            Pas encore de compte ?
            <a href="/register" class="text-indigo-600 hover:underline">Créer un compte</a>
        </p>
    </div>

</body>
</html>
