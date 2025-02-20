<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Technicien - Doc 2 Wheels</title>
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
                <li class="active">
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
            <div class="breadcrumb">
                <a href="/admin/technicians">
                    <i class="fas fa-wrench"></i>
                    Techniciens
                </a>
                <i class="fas fa-chevron-right"></i>
                <span>Modifier</span>
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

        <!-- Edit Technician Content -->
        <div class="admin-content">
            <div class="content-header">
                <h1>Modifier le Technicien</h1>
                <a href="/admin/technicians" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>

            <div class="card">
                <div class="technician-profile-header">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($technician->name) ?>&size=120&background=random" 
                         alt="<?= $technician->name ?>" class="technician-avatar">
                    <div class="technician-info">
                        <h2><?= $technician->name ?></h2>
                        <span class="specialty-badge large">
                            <?php 
                            $icon = match($technician->speciality) {
                                'Mécanique' => 'fa-wrench',
                                'Électrique' => 'fa-bolt',
                                'Carrosserie' => 'fa-car',
                                default => 'fa-tools'
                            };
                            ?>
                            <i class="fas <?= $icon ?>"></i>
                            <?= $technician->speciality ?>
                        </span>
                    </div>
                </div>

                <form method="post" action="/admin/technicians/edit/<?= $technician->id ?>" class="admin-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">
                                <i class="fas fa-user"></i>
                                Nom complet
                            </label>
                            <input type="text" id="name" name="name" required 
                                   class="form-control" value="<?= $technician->name ?>"
                                   placeholder="John Doe">
                        </div>

                        <div class="form-group">
                            <label for="speciality">
                                <i class="fas fa-tools"></i>
                                Spécialité
                            </label>
                            <select id="speciality" name="speciality" required class="form-control">
                                <option value="Mécanique" <?= $technician->speciality === 'Mécanique' ? 'selected' : '' ?>>Mécanique</option>
                                <option value="Électrique" <?= $technician->speciality === 'Électrique' ? 'selected' : '' ?>>Électrique</option>
                                <option value="Carrosserie" <?= $technician->speciality === 'Carrosserie' ? 'selected' : '' ?>>Carrosserie</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">
                                <i class="fas fa-phone"></i>
                                Téléphone
                            </label>
                            <input type="tel" id="phone" name="phone" required 
                                   class="form-control" value="<?= $technician->phone ?>"
                                   placeholder="06 12 34 56 78">
                        </div>

                        <div class="form-group">
                            <label for="email">
                                <i class="fas fa-envelope"></i>
                                Email
                            </label>
                            <input type="email" id="email" name="email" required 
                                   class="form-control" value="<?= $technician->email ?>"
                                   placeholder="john@doc2wheels.com">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="status">
                                <i class="fas fa-circle"></i>
                                Statut
                            </label>
                            <select id="status" name="status" required class="form-control">
                                <option value="available" <?= ($technician->status ?? 'available') === 'available' ? 'selected' : '' ?>>Disponible</option>
                                <option value="busy" <?= ($technician->status ?? '') === 'busy' ? 'selected' : '' ?>>Occupé</option>
                                <option value="offline" <?= ($technician->status ?? '') === 'offline' ? 'selected' : '' ?>>Hors ligne</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="experience">
                                <i class="fas fa-star"></i>
                                Années d'expérience
                            </label>
                            <input type="number" id="experience" name="experience" 
                                   class="form-control" value="<?= $technician->experience ?? '' ?>"
                                   min="0" step="1" placeholder="5">
                        </div>
                    </div>

                    <div class="form-section">
                        <h3><i class="fas fa-home"></i> Domicile de travail</h3>
                        <p class="section-info">Renseignez l'adresse du domicile de travail du technicien</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="location_street">
                                <i class="fas fa-road"></i>
                                Rue
                            </label>
                            <input type="text" id="location_street" name="location_street" required 
                                   class="form-control" value="<?= $location->street ?? '' ?>"
                                   placeholder="123 Rue Principale">
                        </div>

                        <div class="form-group">
                            <label for="location_address">
                                <i class="fas fa-map-marker-alt"></i>
                                Adresse complémentaire
                            </label>
                            <input type="text" id="location_address" name="location_address" required 
                                   class="form-control" value="<?= $location->address ?? '' ?>"
                                   placeholder="Appartement 1">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="location_city">
                                <i class="fas fa-city"></i>
                                Ville
                            </label>
                            <input type="text" id="location_city" name="location_city" required 
                                   class="form-control" value="<?= $location->city ?? '' ?>"
                                   placeholder="Ville">
                        </div>

                        <div class="form-group">
                            <label for="location_postal_code">
                                <i class="fas fa-envelope"></i>
                                Code Postal
                            </label>
                            <input type="text" id="location_postal_code" name="location_postal_code" required 
                                   class="form-control" value="<?= $location->postal_code ?? '' ?>"
                                   placeholder="12345">
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Réinitialiser
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>