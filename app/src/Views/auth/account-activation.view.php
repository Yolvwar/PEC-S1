<?php
include_once __DIR__ . '/../../Helpers/session_helper.php';
?>
<div class="overlay"></div>
<div class="account-activation-popup">
  <h1 class="header">Activation de compte</h1>
  <?php flash('login') ?>
  <p class="message">Votre compte a été activé avec succès. Vous pouvez maintenant vous connecter.</p>
  <a href="/login" class="btn">Se connecter</a>
</div>