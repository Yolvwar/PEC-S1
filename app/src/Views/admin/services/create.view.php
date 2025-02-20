<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Service - Doc 2 Wheels</title>
    <link rel="stylesheet" href="../../../../sass/dist/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                <li>
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
                <li class="active">
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
            <div class="breadcrumb">
                <a href="/admin/services">
                    <i class="fas fa-cogs"></i>
                    Services
                </a>
                <i class="fas fa-chevron-right"></i>
                <span>Nouveau</span>
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

        <!-- Create Service Content -->
        <div class="admin-content">
            <div class="content-header">
                <h1>Nouveau Service</h1>
                <a href="/admin/services" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>

            <div class="card">
                <div class="service-create-header">
                    <div class="service-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <h2>Créer un Nouveau Service</h2>
                    <p>Ajoutez un nouveau service à votre catalogue</p>
                </div>

                <form method="post" action="/admin/services/create" class="admin-form">
                    <div class="form-group">
                        <label for="name">
                            <i class="fas fa-tag"></i>
                            Nom du service
                        </label>
                        <input type="text" id="name" name="name" required 
                               class="form-control" 
                               placeholder="Ex: Révision complète">
                        <small class="form-text">Choisissez un nom clair et descriptif</small>
                    </div>

                    <div class="form-group">
                        <label for="description">
                            <i class="fas fa-align-left"></i>
                            Description détaillée
                        </label>
                        <textarea id="description" name="description" required 
                                  class="form-control" rows="6"
                                  placeholder="Décrivez en détail ce que comprend ce service..."></textarea>
                        <small class="form-text">Une description claire aide les clients à comprendre le service</small>
                    </div>

                    <div class="form-tips">
                        <h3><i class="fas fa-lightbulb"></i> Conseils pour un bon service</h3>
                        <ul>
                            <li>Soyez précis dans la description</li>
                            <li>Mentionnez les points clés inclus</li>
                            <li>Indiquez la durée approximative</li>
                            <li>Précisez les conditions particulières si nécessaire</li>
                        </ul>
                    </div>

                    <div class="form-actions">
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Réinitialiser
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Créer le service
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>