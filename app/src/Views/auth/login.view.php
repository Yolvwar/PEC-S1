<?php
include_once __DIR__ . '/../../helpers/session_helper.php';
?>
<h1 class="header">Connectez-vous</h1>

<?php flash('login') ?>

<form method="post" action="/auth">
  <input type="hidden" name="type" value="login">
  <input type="text" name="name/email"
    placeholder="Username/Email...">
  <input type="password" name="password"
    placeholder="Password...">
  <button type="submit" name="submit">Log In</button>
</form>

<div class="form-sub-msg"><a href="./reset-password.php">Forgotten Password?</a></div>