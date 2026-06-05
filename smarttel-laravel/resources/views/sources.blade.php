@extends('layout')

@section('title', 'Sources')

@section('content')
<div class="px-6 py-12 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Gestion des Sources</h1>
    <p class="text-gray-600 mb-8">Ajoutez, importez et configurez vos sources de données pour alimenter Smartel.</p>

    <!-- Import CSV -->
    <div class="bg-white p-6 rounded-lg shadow mb-10">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Importer un fichier CSV</h2>
        <form action="{{ route('sources.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="file" name="csv_file" class="block w-full text-sm text-gray-600 border rounded p-2" required>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-500 transition">
                Importer
            </button>
        </form>
    </div>

    <!-- Connexion API -->
    <div class="bg-white p-6 rounded-lg shadow mb-10">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Ajouter une API</h2>
        <form action="{{ route('sources.api') }}" method="POST" class="space-y-4">
            @csrf
            <input type="text" name="api_url" placeholder="https://api.exemple.com/data" class="block w-full text-sm text-gray-600 border rounded p-2" required>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-500 transition">
                Connecter
            </button>
        </form>
    </div>

    <!-- Historique des imports -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Historique des Imports</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Nom du fichier</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Date</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($imports as $import)
                <tr>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $import->filename }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $import->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-2 text-sm">
                        <span class="px-2 py-1 text-xs rounded {{ $import->status === 'Succès' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $import->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
