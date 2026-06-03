<script src="https://cdn.tailwindcss.com"></script>

<div class="bg-white">

  <!-- HEADER -->
  <header class="fixed inset-x-0 top-0 z-50 bg-white shadow">
    <nav class="flex items-center justify-between p-6 lg:px-8">
      <!-- Logo -->
      <div class="flex lg:flex-1">
        <a href="/" class="flex items-center gap-2">
        <img src="/smartel.png" alt="Smartel Logo" class="h-12 w-auto" />
      </div>
      <!-- Menu -->
    <div class="hidden lg:flex lg:gap-x-12">
 <nav class="hidden lg:flex lg:gap-x-12">
  <a href="{{ route('accueil') }}" class="text-sm font-semibold text-gray-900 hover:text-indigo-600">Accueil</a>
  <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-gray-900 hover:text-indigo-600">Dashboard</a>
  <a href="{{ route('sources') }}" class="text-sm font-semibold text-gray-900 hover:text-indigo-600">Sources</a>
  <a href="{{ route('analyses') }}" class="text-sm font-semibold text-gray-900 hover:text-indigo-600">Analyses</a>
  <a href="{{ route('parametres') }}" class="text-sm font-semibold text-gray-900 hover:text-indigo-600">Paramètres</a>
</nav>

      </div>
      <!-- CTA -->
      <div class="hidden lg:flex lg:flex-1 lg:justify-end gap-4">
        <a href="{{ route('login') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">Se connecter</a>
        <a href="{{ route('register') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 transition">Commencer</a>
      </div>
    </nav>
  </header>

  <!-- HERO -->
  <section class="relative isolate px-6 pt-32 lg:px-8 bg-gradient-to-tr from-indigo-50 to-white">
    <div class="mx-auto max-w-4xl text-center">
      <h1 class="text-5xl font-bold tracking-tight text-gray-900 sm:text-6xl">
        Transformez vos données en décisions intelligentes
      </h1>
      <p class="mt-6 text-lg leading-8 text-gray-600">
        Collectez, analysez, visualisez et exploitez vos données en temps réel avec Smartel Data Platform.
      </p>
      <div class="mt-10 flex items-center justify-center gap-x-6">
        <a href="#" class="rounded-md bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow hover:bg-indigo-500 transition">Commencer maintenant</a>
        <a href="#" class="text-sm font-semibold text-gray-900 hover:text-indigo-600">Voir une démo →</a>
      </div>
    </div>
  </section>

  <!-- DASHBOARD -->
  <section class="py-24 bg-gray-50">
    <div class="mx-auto max-w-6xl text-center">
      <h2 class="text-3xl font-bold text-gray-900">Dashboard en direct</h2>
      <p class="mt-4 text-gray-600">KPIs et données clés en temps réel.</p>
      <div class="mt-8 bg-white shadow-xl rounded-xl p-6">
        <img src="/img/dashboard-demo.png" alt="Dashboard Aperçu" class="mx-auto rounded-lg" />
      </div>
    </div>
  </section>

  <!-- FONCTIONNALITÉS -->
  <section class="py-24">
    <div class="mx-auto max-w-6xl text-center">
      <h2 class="text-3xl font-bold text-gray-900">Tout ce dont vous avez besoin</h2>
      <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="p-6 bg-indigo-50 rounded-lg shadow hover:shadow-md transition">
          <h3 class="text-lg font-semibold text-indigo-700">📡 Collecte de données</h3>
          <p class="mt-2 text-gray-600">APIs, bases de données, fichiers, applications.</p>
        </div>
        <div class="p-6 bg-indigo-50 rounded-lg shadow hover:shadow-md transition">
          <h3 class="text-lg font-semibold text-indigo-700">📊 Visualisation intelligente</h3>
          <p class="mt-2 text-gray-600">Graphiques interactifs, dashboards personnalisables.</p>
        </div>
        <div class="p-6 bg-indigo-50 rounded-lg shadow hover:shadow-md transition">
          <h3 class="text-lg font-semibold text-indigo-700">🤖 Analyse avancée</h3>
          <p class="mt-2 text-gray-600">IA pour insights et prédictions.</p>
        </div>
        <div class="p-6 bg-indigo-50 rounded-lg shadow hover:shadow-md transition">
          <h3 class="text-lg font-semibold text-indigo-700">🔒 Sécurité & Gouvernance</h3>
          <p class="mt-2 text-gray-600">Contrôle d’accès, conformité totale.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- SECTEURS -->
  <section class="py-24 bg-gray-50">
    <div class="mx-auto max-w-6xl text-center">
      <h2 class="text-3xl font-bold text-gray-900">Des solutions adaptées à votre secteur</h2>
      <div class="mt-8 grid grid-cols-2 sm:grid-cols-4 gap-6">
        <div class="p-4 bg-white shadow rounded hover:bg-indigo-50 transition">Business Intelligence</div>
        <div class="p-4 bg-white shadow rounded hover:bg-indigo-50 transition">Marketing</div>
        <div class="p-4 bg-white shadow rounded hover:bg-indigo-50 transition">Finance</div>
        <div class="p-4 bg-white shadow rounded hover:bg-indigo-50 transition">SIG & Géodata</div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="bg-gray-900 text-white py-12">
    <div class="mx-auto max-w-6xl text-center">
      <p class="text-gray-400">&copy; 2026 Smartel. Tous droits réservés.</p>
    </div>
  </footer>

</div>
