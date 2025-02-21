<?php include_once __DIR__ . '/../../Helpers/session_helper.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres - Doc 2 Wheels</title>
    <link rel="stylesheet" href="../../../sass/dist/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar__container">
        <a href="/home" class="navbar__logo">
        <img src="/sass/images/Doc2Wheels-logo-1.png" alt="Doc 2 Wheels Logo" style="height: 65px;">
      </a>

            <button class="navbar__burger">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <ul class="navbar__menu">
                <li class="navbar__item">
                    <a href="/home"><i class="fas fa-home"></i> Accueil</a>
                </li>
                <li class="navbar__item">
                    <a href="/service_request"><i class="fas fa-wrench"></i> Réparation</a>
                </li>
                <?php if(isset($_SESSION['user_id'])) : ?>
                    <li class="navbar__item dropdown">
                        <a href="#" class="dropdown-toggle">
                            <i class="fas fa-user"></i> 
                            <?php echo explode(" ", $_SESSION['user_username'])[0]; ?>
                            <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="/user/profile">
                                    <i class="fas fa-id-card"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a href="/user/devis">
                                    <i class="fas fa-file-invoice"></i> Mes devis
                                </a>
                            </li>
                            <li>
                                <a href="/user/params" class="active">
                                    <i class="fas fa-cog"></i> Paramètres
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="navbar__item">
                        <a href="/logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                    </li>
                <?php else: ?>
                    <li class="navbar__item">
                        <a href="/login"><i class="fas fa-sign-in-alt"></i> Connexion</a>
                    </li>
                    <li class="navbar__item">
                        <a href="/register"><i class="fas fa-user-plus"></i> Inscription</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <main class="settings-page" style="padding-top: 100px">
        <div class="container">
            <header class="settings-header">
                <h1><i class="fas fa-cog"></i> Paramètres</h1>
                <p>Gérez vos préférences et paramètres de compte</p>
            </header>

            <div class="settings-grid">
                <!-- Section Profil -->
                <section class="settings-section">
                    <h2><i class="fas fa-user-circle"></i> Profil</h2>
                    <div class="settings-content">
                        <div class="profile-picture">
                            <img src="https://via.placeholder.com/150" alt="Photo de profil">
                            <button class="btn btn-outline-primary">
                                <i class="fas fa-camera"></i> Changer la photo
                            </button>
                        </div>
                        <form class="settings-form">
                            <div class="form-group">
                                <label>Nom complet</label>
                                <input type="text" value="John Doe" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" value="john@example.com" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Téléphone</label>
                                <input type="tel" value="+33 6 12 34 56 78" class="form-control">
                            </div>
                        </form>
                    </div>
                </section>

                <!-- Section Notifications -->
                <section class="settings-section">
                    <h2><i class="fas fa-bell"></i> Notifications</h2>
                    <div class="settings-content">
                        <div class="notification-settings">
                            <div class="setting-item">
                                <div class="setting-info">
                                    <h3>Notifications par email</h3>
                                    <p>Recevoir des mises à jour sur vos demandes de service</p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <h3>SMS</h3>
                                    <p>Recevoir des alertes par SMS</p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <h3>Newsletter</h3>
                                    <p>Recevoir nos actualités et promotions</p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section Sécurité -->
                <section class="settings-section">
                    <h2><i class="fas fa-shield-alt"></i> Sécurité</h2>
                    <div class="settings-content">
                        <form class="settings-form">
                            <div class="form-group">
                                <label>Mot de passe actuel</label>
                                <input type="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nouveau mot de passe</label>
                                <input type="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Confirmer le mot de passe</label>
                                <input type="password" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-key"></i> Changer le mot de passe
                            </button>
                        </form>
                    </div>
                </section>

                <!-- Section Préférences -->
                <section class="settings-section">
                    <h2><i class="fas fa-sliders-h"></i> Préférences</h2>
                    <div class="settings-content">
                        <div class="preferences-settings">
                            <div class="setting-item">
                                <div class="setting-info">
                                    <h3>Mode sombre</h3>
                                    <p>Activer le thème sombre</p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <h3>Langue</h3>
                                    <p>Choisir la langue de l'interface</p>
                                </div>
                                <select class="form-control">
                                    <option>Français</option>
                                    <option>English</option>
                                    <option>Español</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section Véhicules -->
                <section class="settings-section">
                    <h2><i class="fas fa-motorcycle"></i> Mes Véhicules</h2>
                    <div class="settings-content">
                        <div class="vehicles-list">
                            <div class="vehicle-card">
                                <div class="vehicle-info">
                                    <i class="fas fa-motorcycle"></i>
                                    <div>
                                        <h3>Yamaha MT-07</h3>
                                        <p>2020 - AB-123-CD</p>
                                    </div>
                                </div>
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="vehicle-card">
                                <div class="vehicle-info">
                                    <i class="fas fa-motorcycle"></i>
                                    <div>
                                        <h3>Honda PCX 125</h3>
                                        <p>2019 - EF-456-GH</p>
                                    </div>
                                </div>
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <button class="btn btn-outline-primary btn-block">
                                <i class="fas fa-plus"></i> Ajouter un véhicule
                            </button>
                        </div>
                    </div>
                </section>
            </div>

            <div class="settings-actions">
                <button type="button" class="btn btn-outline-secondary">
                    <i class="fas fa-undo"></i> Annuler
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
            </div>
        </div>
    </main>

    <script src="../../../src/js/navbar.js"></script>
</body>
</html>
