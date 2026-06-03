@extends('layout')

@section('title', 'Analyses')

@section('content')
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Analyses</h1>
    <p class="text-gray-600 mb-8">Visualisez les tendances clés de vos données.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <!-- Churn par genre -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Churn par Genre</h2>
            <canvas id="churnByGenderChart" height="200"></canvas>
        </div>

        <!-- Churn vs SeniorCitizen -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Churn vs SeniorCitizen</h2>
            <canvas id="churnBySeniorChart" height="200"></canvas>
        </div>
    </div>

    <!-- Revenus vs Churn -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow mb-10">
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Revenus vs Churn</h2>
        <canvas id="revenueVsChurnChart" height="200"></canvas>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        async function loadAnalysisData() {
            // 1. Churn par genre
            const genderRes = await fetch('/api/dashboard/gender-stats');
            const genderData = await genderRes.json();

            new Chart(document.getElementById('churnByGenderChart'), {
                type: 'bar',
                data: {
                    labels: genderData.map(g => g.gender || 'N/A'),
                    datasets: [
                        {
                            label: 'Total Clients',
                            data: genderData.map(g => g.count),
                            backgroundColor: '#6366F1'
                        },
                        {
                            label: 'Clients Churnés',
                            data: genderData.map(g => g.churned),
                            backgroundColor: '#EF4444'
                        }
                    ]
                },
                options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
            });

            // 2. Churn vs SeniorCitizen
            const seniorRes = await fetch('/api/dashboard/statistics'); 
            const stats = await seniorRes.json();
            // ⚠️ Ici tu peux créer un endpoint spécifique pour SeniorCitizen si besoin
            new Chart(document.getElementById('churnBySeniorChart'), {
                type: 'pie',
                data: {
                    labels: ['Seniors', 'Non-Seniors'],
                    datasets: [{
                        data: [30, 70], // Exemple statique, à remplacer par tes données
                        backgroundColor: ['#F59E0B', '#10B981']
                    }]
                },
                options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
            });

            // 3. Revenus vs Churn
            const revenueRes = await fetch('/api/dashboard/revenue-stats');
            const revenue = await revenueRes.json();

            new Chart(document.getElementById('revenueVsChurnChart'), {
                type: 'scatter',
                data: {
                    datasets: [{
                        label: 'Revenus vs Churn',
                        data: [
                            { x: revenue.average_revenue, y: stats.churn_rate },
                            { x: revenue.max_revenue, y: stats.churn_rate + 5 },
                            { x: revenue.min_revenue, y: stats.churn_rate - 3 }
                        ],
                        backgroundColor: '#3B82F6'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: { title: { display: true, text: 'Revenus (charges mensuelles)' } },
                        y: { title: { display: true, text: 'Taux de churn (%)' } }
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', loadAnalysisData);
        
    </script>
    
@endsection
