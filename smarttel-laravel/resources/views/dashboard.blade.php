@extends('layout')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Bienvenue,</h1>
    <p class="text-gray-600 mb-8">Voici un aperçu de vos données aujourd’hui.</p>

    <!-- KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10" id="kpi-container">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700">Revenus</h2>
            <p class="text-2xl font-bold text-indigo-600" id="total-revenue">Chargement...</p>
            <span class="text-green-600" id="revenue-trend">--</span>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700">Clients Actifs</h2>
            <p class="text-2xl font-bold text-indigo-600" id="active-count">Chargement...</p>
            <span class="text-green-600" id="active-trend">--</span>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700">Clients Partis</h2>
            <p class="text-2xl font-bold text-red-600" id="churned-count">Chargement...</p>
            <span class="text-red-600" id="churn-trend">--</span>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700">Taux de Churn</h2>
            <p class="text-2xl font-bold text-orange-600" id="churn-rate">Chargement...</p>
            <span class="text-gray-600" id="total-customers">Total clients: --</span>
        </div>
    </div>

    <!-- Revenus Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Statistiques des Revenus</h2>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Revenu Moyen Mensuel:</span>
                    <span class="font-semibold text-indigo-600" id="avg-revenue">--</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Revenu Total:</span>
                    <span class="font-semibold text-indigo-600" id="sum-revenue">--</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Revenu Maximum:</span>
                    <span class="font-semibold text-green-600" id="max-revenue">--</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Revenu Minimum:</span>
                    <span class="font-semibold text-red-600" id="min-revenue">--</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Distribution par Genre</h2>
            <div id="gender-stats" class="space-y-3">
                Chargement...
            </div>
        </div>
    </div>

    <!-- Clients à Risque -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Clients à Risque de Départ</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">ID Client</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Genre</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Statut</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody id="risk-customers" class="divide-y">
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-600">Chargement...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const API_BASE = '/api/dashboard';

        async function loadDashboardData() {
            try {
                // Charger les statistiques principales
                const statsRes = await fetch(`${API_BASE}/statistics`);
                const stats = await statsRes.json();

                document.getElementById('total-revenue').textContent = 
                    new Intl.NumberFormat('fr-FR', { 
                        style: 'currency', 
                        currency: 'XOF' 
                    }).format(stats.total_revenue || 0);
                document.getElementById('active-count').textContent = stats.active_count || 0;
                document.getElementById('churned-count').textContent = stats.churned_count || 0;
                document.getElementById('churn-rate').textContent = (stats.churn_rate || 0) + '%';
                document.getElementById('total-customers').textContent = `Total clients: ${stats.total_customers || 0}`;

                // Charger les statistiques de revenus
                const revenueRes = await fetch(`${API_BASE}/revenue-stats`);
                const revenue = await revenueRes.json();

                const formatCurrency = (val) => new Intl.NumberFormat('fr-FR', { 
                    style: 'currency', 
                    currency: 'XOF' 
                }).format(val || 0);

                document.getElementById('avg-revenue').textContent = formatCurrency(revenue.average_revenue);
                document.getElementById('sum-revenue').textContent = formatCurrency(revenue.total_revenue);
                document.getElementById('max-revenue').textContent = formatCurrency(revenue.max_revenue);
                document.getElementById('min-revenue').textContent = formatCurrency(revenue.min_revenue);

                // Charger les statistiques par genre
                const genderRes = await fetch(`${API_BASE}/gender-stats`);
                const genderData = await genderRes.json();
                
                const genderContainer = document.getElementById('gender-stats');
                genderContainer.innerHTML = genderData.map(g => `
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">${g.gender || 'N/A'}:</span>
                        <span class="text-sm">
                            <span class="font-semibold text-indigo-600">${g.count || 0}</span> 
                            <span class="text-gray-500">(Churn: ${g.churned || 0})</span>
                        </span>
                    </div>
                `).join('');

                // Charger les clients à risque
                const riskRes = await fetch(`${API_BASE}/risk-customers`);
                const riskData = await riskRes.json();

                const riskTable = document.getElementById('risk-customers');
                if (riskData.length === 0) {
                    riskTable.innerHTML = '<tr><td colspan="4" class="px-4 py-4 text-center text-gray-600">Aucun client à risque</td></tr>';
                } else {
                    riskTable.innerHTML = riskData.map(risk => `
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-700">${risk.customer_id || 'N/A'}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">${risk.customer?.gender || 'N/A'}</td>
                            <td class="px-4 py-2 text-sm">
                                <span class="inline-block px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded">
                                    ${risk.churn_status}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-sm">
                                <button class="text-indigo-600 hover:text-indigo-900 font-semibold">Détails</button>
                            </td>
                        </tr>
                    `).join('');
                }

            } catch (error) {
                console.error('Erreur lors du chargement des données:', error);
                alert('Erreur lors du chargement des données du dashboard');
            }
        }

        // Charger les données au chargement de la page
        document.addEventListener('DOMContentLoaded', loadDashboardData);
        
        // Rafraîchir les données toutes les 30 secondes
        setInterval(loadDashboardData, 30000);
    </script>
@endsection
