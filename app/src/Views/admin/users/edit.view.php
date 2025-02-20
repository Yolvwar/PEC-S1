<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'Utilisateur - Doc 2 Wheels</title>
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
                <li class="active">
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
            <div class="breadcrumb">
                <a href="/admin/users">
                    <i class="fas fa-users"></i>
                    Utilisateurs
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

        <!-- Edit User Content -->
        <div class="admin-content">
            <div class="content-header">
                <h1>Modifier l'Utilisateur</h1>
                <a href="/admin/users" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>

            <div class="card">
                <div class="user-profile-header">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($user->name) ?>&size=120&background=random" 
                         alt="<?= $user->name ?>" class="user-avatar">
                    <div class="user-info">
                        <h2><?= $user->name ?></h2>
                        <p class="user-email"><?= $user->email ?></p>
                    </div>
                </div>

                <form method="post" action="/admin/users/edit/<?= $user->id ?>" class="admin-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">
                                <i class="fas fa-user"></i>
                                Nom complet
                            </label>
                            <input type="text" id="name" name="name" required 
                                   class="form-control" value="<?= $user->name ?>"
                                   placeholder="John Doe">
                        </div>

                        <div class="form-group">
                            <label for="username">
                                <i class="fas fa-at"></i>
                                Nom d'utilisateur
                            </label>
                            <input type="text" id="username" name="username" required 
                                   class="form-control" value="<?= $user->username ?>"
                                   placeholder="johndoe">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">
                                <i class="fas fa-envelope"></i>
                                Email
                            </label>
                            <input type="email" id="email" name="email" required 
                                   class="form-control" value="<?= $user->email ?>"
                                   placeholder="john@example.com">
                        </div>

                        <div class="form-group">
                            <label for="role">
                                <i class="fas fa-user-tag"></i>
                                Rôle
                            </label>
                            <select id="role" name="role" required class="form-control">
                                <option value="user" <?= $user->role === 'user' ? 'selected' : '' ?>>Utilisateur</option>
                                <option value="admin" <?= $user->role === 'admin' ? 'selected' : '' ?>>Administrateur</option>
                                <option value="technician" <?= $user->role === 'technician' ? 'selected' : '' ?>>Technicien</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">
                                <i class="fas fa-lock"></i>
                                Nouveau mot de passe (laisser vide pour ne pas changer)
                            </label>
                            <div class="password-input">
                                <input type="password" id="password" name="password"
                                       class="form-control" placeholder="••••••••">
                                <i class="fas fa-eye toggle-password"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">
                                <i class="fas fa-lock"></i>
                                Confirmer le nouveau mot de passe
                            </label>
                            <div class="password-input">
                                <input type="password" id="confirm_password" name="confirm_password"
                                       class="form-control" placeholder="••••••••">
                                <i class="fas fa-eye toggle-password"></i>
                            </div>
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