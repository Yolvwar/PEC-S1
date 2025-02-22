<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Doc 2 Wheels</title>
    <link rel="stylesheet" href="../../../sass/dist/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-sidebar__logo">
            <i class="fas fa-motorcycle"></i>
            <span>Doc 2 Wheels</span>
        </div>
        
        <nav class="admin-sidebar__nav">
            <ul>
                <li class="active">
                    <a href="/admin">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/users">
                        <i class="fas fa-users"></i>
                        <span>Utilisateurs</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/technicians">
                        <i class="fas fa-wrench"></i>
                        <span>Techniciens</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/services">
                        <i class="fas fa-cogs"></i>
                        <span>Services</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/service_requests">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Demandes</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Top Bar -->
        <header class="admin-header">
            <div class="admin-header__search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Rechercher...">
            </div>
            
            <div class="admin-header__profile">
                <div class="profile">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff" alt="Profile">
                    <span>Admin</span>
                    <a href="/logout" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </a>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="admin-content">
            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-card__icon" style="background: #4CAF50;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-card__info">
                        <h3>Total Utilisateurs</h3>
                        <p class="number"><?= count($users) ?></p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card__icon" style="background: #2196F3;">
                        <i class="fas fa-wrench"></i>
                    </div>
                    <div class="stat-card__info">
                        <h3>Total Techniciens</h3>
                        <p class="number"><?= count($technicians) ?></p>
                    </div>
                </div>
            </div>

            <section class="admin-dashboard">
                <h1>Suivi et Analyse des Performances</h1>
                <div class="dashboard-metrics">
                    <div class="metric">
                        <h2>Revenus générés</h2>
                        <p><?= $revenueGenerated ?> €</p>
                        <canvas id="revenueChart"></canvas>
                    </div>
                    <div class="metric">
                        <h2>Revenus par technicien</h2>
                        <ul>
                            <?php foreach (array_slice($revenueByTechnician, 0, 10) as $index => $technician): ?>
                                <li>
                                    <?php if ($index === 0): ?>
                                        <i class="fas fa-crown" style="color: gold;"></i>
                                    <?php elseif ($index === 1): ?>
                                        <i class="fas fa-crown" style="color: silver;"></i>
                                    <?php elseif ($index === 2): ?>
                                        <i class="fas fa-crown" style="color: bronze;"></i>
                                    <?php endif; ?>
                                    <?= htmlspecialchars($technician->name) ?>: <?= htmlspecialchars($technician->revenue) ?> €
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="metric-group">
                        <h2>Métriques d'Interventions</h2>
                        <div class="metric">
                            <h3>Nombre d'interventions</h3>
                            <p><?= $numberOfInterventions ?></p>
                        </div>
                        <div class="metric">
                            <h3>Taux de retour</h3>
                            <p><?= $completedRate ?>%</p>
                        </div>
                        <div class="metric">
                            <h3>Interventions à finir</h3>
                            <p><?= $pendingInterventions ?></p>
                        </div>
                    </div>
                    <div class="metric">
                        <h2>Revenus par période</h2>
                        
                        <p>Ce mois-ci : <?= $revenueThisMonth ?> €</p>
                        <p>Dernier mois : <?= $revenueLastMonth ?> €</p>
                        <p>Dernière année : <?= $revenueLastYear ?> €</p>
                    </div>
                    <div class="metric">
                        <h2>Satisfaction client</h2>
                        <p>Moyenne : <?= $customerSatisfaction !== null ? round($customerSatisfaction, 2) : 'N/A' ?>
                            <i class="fas fa-star" style="color: gold;"></i>
                        </p>
                    </div>
                </div>

                <!-- Graphs Section -->
                <div class="graphs">
                    <h2>Graphiques</h2>
                    <div class="graphs-container">
                    <canvas id="interventionsChart"></canvas>
                    <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <style>
        .graphs-container {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}

.graphs-container canvas {
    flex: 1 1 calc(50% - 10px);
    margin: 5px;
}
    </style>
    

    <script>
        // Data for the charts
        const interventionsData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Nombre d\'interventions',
                data: <?= json_encode(array_column($interventionsData, 'count')) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        const revenueData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Revenus générés',
                data: <?= json_encode(array_column($revenueData, 'revenue')) ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        // Configurations for the charts
        const configInterventions = {
            type: 'line',
            data: interventionsData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        const configRevenue = {
            type: 'line',
            data: revenueData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Render the charts
        const interventionsChart = new Chart(
            document.getElementById('interventionsChart'),
            configInterventions
        );

        const revenueChart = new Chart(
            document.getElementById('revenueChart'),
            configRevenue
        );
    </script>
</body>
</html>