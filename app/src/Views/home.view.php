<?php
include_once __DIR__ . '/../Helpers/session_helper.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doc 2 Wheels - Réparation de deux-roues à domicile</title>
  <link rel="stylesheet" href="../../sass/dist/css/main.css" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body>
  <nav class="navbar">
    <div class="navbar__container">
      <a href="/" class="navbar__logo">
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
                    <li class="navbar__item">
                    <a href="/opinion-feedback"><i class="fas fa-comments"></i> Avis et Retour d'Expérience</a>
                  </li>
                <?php endif; ?>
            </ul>
    </div>
  </nav>

  <section class="hero">
    <div class="hero__background">
      <video autoplay muted loop playsinline>
        <source src="/sass/images/video_hero.mp4" type="video/mp4" />
      </video>
    </div>
    <div class="hero__content">
      <h1>Doc 2 Wheels</h1>
      <?php if(isset($_SESSION['user_id'])) : ?>
        <p>Bienvenue <?php echo explode(" ", $_SESSION['user_username'])[0]; ?> !</p>
      <?php endif; ?>
      <p>
        Service de réparation de deux-roues à domicile, au bureau ou dans la
        rue. Notre mission est de faciliter la vie des motards et scootéristes
        dans les mégapoles avec des solutions rapides et efficaces.
      </p>
      <a href="/service_request" class="button button-intervention">
        <i class="fas fa-wrench"></i>
        Demander une intervention
      </a>
    </div>
  </section>

  <section class="services">
    <div class="container">
      <div class="services__grid">
        <div class="services__card">
          <i class="fas fa-home"></i>
          <h3>Service à domicile</h3>
          <p>
            Intervention directement chez vous ou sur votre lieu de travail
          </p>
        </div>
        <div class="services__card">
          <i class="fas fa-bolt"></i>
          <h3>Intervention rapide</h3>
          <p>Prise en charge rapide des urgences mécaniques</p>
        </div>
        <div class="services__card">
          <i class="fas fa-wallet"></i>
          <h3>Prix compétitifs</h3>
          <p>Des tarifs transparents et adaptés à tous les budgets</p>
        </div>
      </div>
    </div>
  </section>

  <section class="cta-section">
    <div class="container">
      <h2>Besoin d'une réparation ?</h2>
      <p>
        Faites confiance à nos experts pour prendre soin de votre deux-roues
      </p>
      <?php if(!isset($_SESSION['user_id'])) : ?>
        <a href="/register" class="btn">Commencer maintenant</a>
      <?php else : ?>
        <a href="/service_request" class="btn">Demander une réparation</a>
      <?php endif; ?>
    </div>
  </section>
  <section class="feedback-section">
    <div class="container">
      <h2>Votre avis compte !</h2>
      <p>
        Nous apprécions vos retours pour améliorer nos services.
      </p>
      <a href="/opinion-feedback" class="btn btn-feedback-inverse">
        <i class="fas fa-comments"></i> Donnez votre avis
      </a>
    </div>
</section>

  <script src="../../src/js/navbar.js"></script>
</body>

</html>