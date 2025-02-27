<?php
include_once __DIR__ . '/../../Helpers/session_helper.php';
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inscription - Doc 2 Wheels</title>
    <link rel="stylesheet" href="../../../sass/dist/css/main.css" />
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
          <li class="navbar__item">
            <a href="/login"><i class="fas fa-sign-in-alt"></i> Connexion</a>
          </li>
          <li class="navbar__item active">
            <a href="/register"><i class="fas fa-user-plus"></i> Inscription</a>
          </li>
          <li class="navbar__item">
              <a href="/opinion-feedback"><i class="fas fa-comments"></i> Avis et Retour d'Expérience</a>
            </li>
        </ul>
      </div>
    </nav>

    <div class="container" style="padding-top: 80px">
      <div class="auth-card">
        <div class="auth-header">
          <h2>Créer un compte</h2>
          <p>Rejoignez Doc 2 Wheels pour gérer vos réparations de deux-roues</p>
        </div>

        <?php flash('register') ?>

        <form class="auth-form" method="post" action="/register">
          <input type="hidden" name="type" value="register">
          
          <div class="form-group">
            <label for="name">
              <i class="fas fa-user"></i>
              Nom complet
            </label>
            <input 
              type="text" 
              id="name" 
              name="name"
              placeholder="John Doe" 
              required 
            />
          </div>

          <div class="form-group">
            <label for="username">
              <i class="fas fa-user-circle"></i>
              Nom d'utilisateur
            </label>
            <input 
              type="text" 
              id="username" 
              name="username"
              placeholder="johndoe" 
              required 
            />
          </div>

          <div class="form-group">
            <label for="email">
              <i class="fas fa-envelope"></i>
              Email
            </label>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="john@example.com"
              required
            />
          </div>

          <div class="form-group">
            <label for="password">
              <i class="fas fa-lock"></i>
              Mot de passe
            </label>
            <div class="password-input">
              <input
                type="password"
                id="password"
                name="password"
                placeholder="Minimum 8 caractères"
                required
              />
              <i class="fas fa-eye toggle-password"></i>
            </div>
          </div>

          <div class="form-group">
            <label for="confirm-password">
              <i class="fas fa-lock"></i>
              Confirmer le mot de passe
            </label>
            <div class="password-input">
              <input
                type="password"
                id="confirm-password"
                name="confirm_password"
                placeholder="Confirmer votre mot de passe"
                required
              />
              <i class="fas fa-eye toggle-password"></i>
            </div>
          </div>

          <div class="form-group terms">
            <input type="checkbox" id="terms" required />
            <label for="terms">
              J'accepte les <a href="#">conditions d'utilisation</a> et la
              <a href="#">politique de confidentialité</a>
            </label>
          </div>

          <button type="submit" name="submit" class="btn btn-primary btn-block">
            <i class="fas fa-user-plus"></i> S'inscrire
          </button>

          <div class="auth-footer">
            <p>Déjà inscrit ? <a href="./login">Connectez-vous</a></p>
          </div>
        </form>
      </div>
    </div>

    <script src="../../../src/js/navbar.js"></script>
  </body>
</html>