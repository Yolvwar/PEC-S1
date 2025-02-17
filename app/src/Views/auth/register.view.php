<?php
include_once __DIR__ . '/../../helpers/session_helper.php';
?>

<h1 class="header">Créer votre compte</h1>

<?php flash('register') ?>

<form method="post" action="/auth">
  <input type="hidden" name="type" value="register">
  <input type="text" name="name"
    placeholder="Full name...">
  <input type="text" name="email"
    placeholder="Email...">
  <input type="text" name="username"
    placeholder="Username...">
  <input type="password" name="password"
    placeholder="Password...">
  <input type="password" name="confirm_password"
    placeholder="Repeat password">
  <button type="submit" name="submit">Sign Up</button>
</form>

<?php

?>