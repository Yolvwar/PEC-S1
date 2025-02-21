<?php
include_once __DIR__ . '/../Helpers/session_helper.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Avis et Retour d'Expérience</title>
  <link rel="stylesheet" href="../../sass/dist/css/main.css" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
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
                <a href="/user/params">
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
          <a href="/user_opinion-feedback"><i class="fas fa-comments"></i> Avis et Retour d'Expérience</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>

  <section class="feedback">
    <div class="container">
      <h1>Avis et Retour d'Expérience</h1>
      <form action="/submit_feedback" method="POST">
        <div class="form-group">
          <label for="rating">Notez le service du technicien :</label>
          <select name="rating" id="rating" required>
            <option value="1">1 - Très mauvais</option>
            <option value="2">2 - Mauvais</option>
            <option value="3">3 - Moyen</option>
            <option value="4">4 - Bon</option>
            <option value="5">5 - Excellent</option>
          </select>
        </div>
        <div class="form-group">
          <label for="comment">Laissez un commentaire :</label>
          <textarea name="comment" id="comment" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn">Soumettre</button>
      </form>
    </div>
  </section>

  <script src="../../src/js/navbar.js"></script>
</body>

</html>