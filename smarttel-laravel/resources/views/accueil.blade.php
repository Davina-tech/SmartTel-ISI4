<script src="https://cdn.tailwindcss.com"></script>

<div class="bg-gradient-to-br from-gray-50 to-indigo-50 min-h-screen">

  <!-- HEADER -->
  <header class="fixed inset-x-0 top-0 z-50 bg-white/90 backdrop-blur-md shadow-sm transition">
    <nav class="flex items-center justify-between p-6 lg:px-12">
      <!-- Logo -->
      <div class="flex lg:flex-1 items-center gap-2">
        <img src="/smartel.png" alt="Smartel Logo" class="h-10 w-auto" />
      </div>

      <!-- Menu -->
      <div class="hidden lg:flex lg:gap-x-10">
        <a href="{{ route('accueil') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition">Accueil</a>
        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition">Dashboard</a>
        <a href="{{ route('analyses') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition">Analyses</a>
      </div>

      <!-- CTA -->
      <div class="hidden lg:flex lg:flex-1 lg:justify-end gap-4">
        <a href="{{ route('login') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">Se connecter</a>
        <a href="{{ route('register') }}" class="rounded-md bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 transition">Commencer</a>
      </div>
    </nav>
  </header>

  <!-- HERO SMARTEL -->
  <section class="relative isolate px-6 pt-40 lg:px-8 text-center">
    <span class="inline-block text-sm font-semibold text-indigo-600 bg-indigo-100 px-4 py-1 rounded-full mb-6 shadow-sm">
      Plateforme intelligente de données
    </span>

    <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight text-gray-900 leading-tight">
      Transformez vos données en décisions <span class="text-indigo-600">intelligentes</span>
    </h1>

    <p class="mt-6 text-lg text-gray-600 max-w-2xl mx-auto">
      Collectez, analysez, visualisez et exploitez vos données en temps réel avec Smartel Data Platform.
    </p>

    <div class="mt-10 flex items-center justify-center gap-x-6">
      <a href="{{ route('register') }}" class="rounded-md bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-lg hover:bg-indigo-500 transition">
        Commencer maintenant
      </a>
      <a href="#" class="text-sm font-semibold text-gray-900 hover:text-indigo-600 transition">
        Voir une démo →
      </a>
    </div>

    <!-- Icônes de fonctionnalités -->
    <div class="mt-20 grid grid-cols-1 sm:grid-cols-3 gap-10 text-center">
      <div class="flex flex-col items-center">
        <div class="bg-indigo-100 text-indigo-600 p-4 rounded-full mb-3 shadow-sm">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 1.657-1.343 3-3 3S6 12.657 6 11s1.343-3 3-3 3 1.343 3 3z" />
          </svg>
        </div>
        <h3 class="font-semibold text-gray-900">Sécurisé</h3>
        <p class="text-gray-600 text-sm">Données protégées</p>
      </div>

      <div class="flex flex-col items-center">
        <div class="bg-indigo-100 text-indigo-600 p-4 rounded-full mb-3 shadow-sm">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m4 0h-1v-4h-1" />
          </svg>
        </div>
        <h3 class="font-semibold text-gray-900">En temps réel</h3>
        <p class="text-gray-600 text-sm">Mises à jour instantanées</p>
      </div>

      <div class="flex flex-col items-center">
        <div class="bg-indigo-100 text-indigo-600 p-4 rounded-full mb-3 shadow-sm">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3V3z" />
          </svg>
        </div>
        <h3 class="font-semibold text-gray-900">Scalable</h3>
        <p class="text-gray-600 text-sm">Pour toutes les tailles</p>
      </div>
    </div>
  </section>

  <!-- FONCTIONNALITÉS -->
  <section class="py-24">
    <div class="mx-auto max-w-6xl text-center">
      <h2 class="text-3xl font-bold text-gray-900 mb-12">Tout ce dont vous avez besoin</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition hover:-translate-y-1">
          <h3 class="text-lg font-semibold text-indigo-700">Collecte de données</h3>
          <p class="mt-2 text-gray-600">APIs, bases de données, fichiers, applications.</p>
        </div>
        <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition hover:-translate-y-1">
          <h3 class="text-lg font-semibold text-indigo-700">Visualisation intelligente</h3>
          <p class="mt-2 text-gray-600">Graphiques interactifs, dashboards personnalisables.</p>
        </div>
        <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition hover:-translate-y-1">
          <h3 class="text-lg font-semibold text-indigo-700">Analyse avancée</h3>
          <p class="mt-2 text-gray-600">IA pour insights et prédictions.</p>
        </div>
        <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition hover:-translate-y-1">
          <h3 class="text-lg font-semibold text-indigo-700">Sécurité & Gouvernance</h3>
          <p class="mt-2 text-gray-600">Contrôle d’accès, conformité totale.</p>
        </div>
      </div>
    </div>
  </section>

 <!-- SECTEURS -->
<section class="py-24 bg-gray-50">
  <div class="mx-auto max-w-6xl text-center">
    <h2 class="text-3xl font-bold text-gray-900 mb-12">Des solutions adaptées à votre secteur</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
      
      <!-- Business Intelligence -->
      <div class="group p-6 bg-white rounded-lg shadow hover:shadow-lg transition hover:-translate-y-1">
        <img src="/busness.png" alt="Business Intelligence" class="mx-auto h-16 w-16 mb-4 opacity-80 group-hover:opacity-100 transition">
        <h3 class="text-lg font-semibold text-indigo-700">Business Intelligence</h3>
        <p class="mt-2 text-gray-600 text-sm">Optimisez vos décisions grâce aux données.</p>
      </div>

      <!-- Marketing -->
      <div class="group p-6 bg-white rounded-lg shadow hover:shadow-lg transition hover:-translate-y-1">
        <img src="/mark.jpg" alt="Marketing" class="mx-auto h-16 w-16 mb-4 opacity-80 group-hover:opacity-100 transition">
        <h3 class="text-lg font-semibold text-indigo-700">Marketing</h3>
        <p class="mt-2 text-gray-600 text-sm">Analysez vos campagnes et vos clients.</p>
      </div>

      <!-- Finance -->
      <div class="group p-6 bg-white rounded-lg shadow hover:shadow-lg transition hover:-translate-y-1">
        <img src="/finance.jpg" alt="Finance" class="mx-auto h-16 w-16 mb-4 opacity-80 group-hover:opacity-100 transition">
        <h3 class="text-lg font-semibold text-indigo-700">Finance</h3>
        <p class="mt-2 text-gray-600 text-sm">Suivez vos revenus et vos risques.</p>
      </div>

      <!-- SIG & Géodata -->
      <div class="group p-6 bg-white rounded-lg shadow hover:shadow-lg transition hover:-translate-y-1">
        <img src="/images/geodata.png" alt="SIG & Géodata" class="mx-auto h-16 w-16 mb-4 opacity-80 group-hover:opacity-100 transition">
        <h3 class="text-lg font-semibold text-indigo-700">SIG & Géodata</h3>
        <p class="mt-2 text-gray-600 text-sm">Cartographiez et exploitez vos données spatiales.</p>
      </div>

    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="bg-gray-900 text-white py-12">
  <div class="mx-auto max-w-6xl text-center">
    <img src="/smartel.png" alt="Smartel Logo" class="mx-auto h-12 mb-4 opacity-80">
    <p class="text-gray-400">&copy; 2026 Smartel. Tous droits réservés.</p>
  </div>
</footer>

</div>
