<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Technicien - Doc 2 Wheels</title>
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

        <!-- Create Technician Content -->
        <div class="admin-content">
            <div class="content-header">
                <h1>Ajouter un Technicien</h1>
                <a href="/admin/technicians" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>

            <div class="card">
                <div class="onboarding-header">
                    <div class="onboarding-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h2>Nouveau Technicien</h2>
                    <p>Remplissez les informations ci-dessous pour ajouter un nouveau technicien à l'équipe.</p>
                </div>

                <form method="post" action="/admin/technicians/create" class="admin-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">
                                <i class="fas fa-user"></i>
                                Nom complet
                            </label>
                            <input type="text" id="name" name="name" required 
                                   class="form-control" placeholder="John Doe">
                            <small class="form-text">Nom et prénom du technicien</small>
                        </div>

                        <div class="form-group">
                            <label for="speciality">
                                <i class="fas fa-tools"></i>
                                Spécialité
                            </label>
                            <select id="speciality" name="speciality" required class="form-control">
                                <option value="">Sélectionnez une spécialité</option>
                                <option value="Mécanique">Mécanique</option>
                                <option value="Électrique">Électrique</option>
                                <option value="Carrosserie">Carrosserie</option>
                            </select>
                            <small class="form-text">Domaine d'expertise principal</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">
                                <i class="fas fa-phone"></i>
                                Téléphone
                            </label>
                            <input type="tel" id="phone" name="phone" required 
                                   class="form-control" placeholder="06 12 34 56 78"
                                   pattern="[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}">
                            <small class="form-text">Format: 06 12 34 56 78</small>
                        </div>

                        <div class="form-group">
                            <label for="email">
                                <i class="fas fa-envelope"></i>
                                Email professionnel
                            </label>
                            <input type="email" id="email" name="email" required 
                                   class="form-control" placeholder="john.doe@doc2wheels.com">
                            <small class="form-text">Sera utilisé pour les communications internes</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="experience">
                                <i class="fas fa-star"></i>
                                Années d'expérience
                            </label>
                            <input type="number" id="experience" name="experience" 
                                   class="form-control" min="0" step="1" placeholder="5">
                            <small class="form-text">Nombre d'années d'expérience dans le domaine</small>
                        </div>

                        <div class="form-group">
                            <label for="status">
                                <i class="fas fa-circle"></i>
                                Statut initial
                            </label>
                            <select id="status" name="status" required class="form-control">
                                <option value="available">Disponible</option>
                                <option value="busy">Occupé</option>
                                <option value="offline">Hors ligne</option>
                            </select>
                            <small class="form-text">Statut de disponibilité par défaut</small>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3><i class="fas fa-shield-alt"></i> Accès au système</h3>
                        <p class="section-info">Un compte sera automatiquement créé avec ces informations</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">
                                <i class="fas fa-lock"></i>
                                Mot de passe
                            </label>
                            <div class="password-input">
                                <input type="password" id="password" name="password" required 
                                       class="form-control" placeholder="••••••••">
                                <i class="fas fa-eye toggle-password"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">
                                <i class="fas fa-lock"></i>
                                Confirmer le mot de passe
                            </label>
                            <div class="password-input">
                                <input type="password" id="confirm_password" name="confirm_password" 
                                       required class="form-control" placeholder="••••••••">
                                <i class="fas fa-eye toggle-password"></i>
                            </div>
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
                        class="form-control" placeholder="123 Rue Principale">
                </div>

                <div class="form-group">
                    <label for="location_address">
                        <i class="fas fa-map-marker-alt"></i>
                        Adresse complémentaire
                    </label>
                    <input type="text" id="location_address" name="location_address" required 
                        class="form-control" placeholder="Appartement 1">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="location_city">
                        <i class="fas fa-city"></i>
                        Ville
                    </label>
                    <input type="text" id="location_city" name="location_city" required 
                        class="form-control" placeholder="Ville">
                </div>

                <div class="form-group">
                    <label for="location_postal_code">
                        <i class="fas fa-envelope"></i>
                        Code Postal
                    </label>
                    <input type="text" id="location_postal_code" name="location_postal_code" required 
                        class="form-control" placeholder="12345">
                </div>
            </div>

    <div class="form-actions">
        <button type="reset" class="btn btn-secondary">
            <i class="fas fa-undo"></i> Réinitialiser
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Ajouter le technicien
        </button>
    </div>
</form>
            </div>
        </div>
    </main>

    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>
</html>