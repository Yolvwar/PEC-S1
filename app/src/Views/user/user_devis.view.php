<?php
include_once __DIR__ . '/../../Helpers/session_helper.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Devis - Doc 2 Wheels</title>
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
                    <li class="navbar__item">
                        <a href="/admin"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    </li>
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

    <main class="devis-page">
        <div class="container">
            <header class="devis-header">
                <h1><i class="fas fa-file-invoice"></i> Mes Devis</h1>
                <?php flash('user_devis') ?>
            </header>

            <?php if (empty($devis)): ?>
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h2>Aucun devis pour le moment</h2>
                    <p>Vos devis apparaîtront ici une fois que vous aurez fait une demande de réparation.</p>
                    <a href="/service_request" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Demander une réparation
                    </a>
                </div>
            <?php else: ?>
                <div class="devis-grid">
                    <?php foreach ($devis as $devis_item): ?>
                        <div class="devis-card">
                            <div class="devis-card__header">
                                <div class="service-type">
                                    <i class="fas fa-wrench"></i>
                                    <h3><?php echo $devis_item->service_name; ?></h3>
                                </div>
                                <span class="devis-date">
                                    <i class="far fa-calendar"></i>
                                    <?php echo date('d/m/Y', strtotime($devis_item->created_at)); ?>
                                </span>
                            </div>
                            
                            <!-- <div class="devis-card__content">
                                <div class="location-info">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <p><?php echo $devis_item->location_street . ', ' . 
                                              $devis_item->location_address . ', ' . 
                                              $devis_item->location_city . ', ' . 
                                              $devis_item->location_postal_code; ?></p>
                                </div>
                                
                                <div class="description">
                                    <i class="fas fa-align-left"></i>
                                    <p><?php echo $devis_item->description; ?></p>
                                </div>

                                <div class="time-slot">
                                    <i class="fas fa-clock"></i>
                                    <p><?php echo $devis_item->time_range; ?></p>
                                </div>
                            </div> -->

                            <div class="devis-card__footer">
                                <div class="estimated-cost">
                                    <span class="label">Coût estimé</span>
                                    <span class="amount"><?php echo $devis_item->estimated_cost; ?> €</span>
                                </div>
                                <button class="btn btn-outline">
                                    <i class="fas fa-download"></i> Télécharger
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <script src="../../../src/js/navbar.js"></script>
</body>
</html>