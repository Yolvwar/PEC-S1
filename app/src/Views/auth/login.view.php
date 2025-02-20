<?php
include_once __DIR__ . '/../../Helpers/session_helper.php';
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connexion - Doc 2 Wheels</title>
    <link rel="stylesheet" href="../../../sass/dist/css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  </head>
  <body>
  <nav class="navbar">
      <div class="navbar__container">
        <a href="/home" class="navbar__logo">Doc 2 Wheels</a>

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
          <li class="navbar__item active">
            <a href="/login"><i class="fas fa-sign-in-alt"></i> Connexion</a>
          </li>
          <li class="navbar__item">
            <a href="/register"><i class="fas fa-user-plus"></i> Inscription</a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container" style="padding-top: 80px">
      <div class="auth-card">
        <div class="auth-header">
          <h2>Connexion</h2>
          <p>Connectez-vous à votre compte Doc 2 Wheels</p>
        </div>

        <?php flash('login') ?>

        <form class="auth-form" method="post" action="/login">
          <input type="hidden" name="type" value="login">
          
          <div class="form-group">
            <label for="email">
              <i class="fas fa-envelope"></i>
              Email/Nom d'utilisateur
            </label>
            <input
              type="text"
              id="email"
              name="name/email"
              placeholder="exemple@email.com"
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
                placeholder="Votre mot de passe"
                required
              />
              <i class="fas fa-eye toggle-password"></i>
            </div>
          </div>

          <div class="remember-me">
            <div class="checkbox-wrapper">
              <input type="checkbox" id="remember" name="remember" />
              <label for="remember">Se souvenir de moi</label>
            </div>
            <a href="./reset-password.php" class="forgot-password">Mot de passe oublié ?</a>
          </div>

          <button type="submit" name="submit" class="btn btn-primary btn-block">
            <i class="fas fa-sign-in-alt"></i>
            Se connecter
          </button>
        </form>

        <div class="auth-footer">
          <p>
            Pas de compte ?
            <a href="./register.php">Inscrivez-vous</a>
          </p>
        </div>
      </div>
    </div>
  </body>
  <script src="../../../src/js/navbar.js"></script>
</html>