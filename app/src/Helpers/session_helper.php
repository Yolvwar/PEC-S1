<?php
// Si la session n'est pas démarrée, on la démarre

/*if(session_status() == 0) {
  session_start();
}*/
function flash($name = '', $message = '', $class = 'alert alert-success') {
  if (!empty($name)) {
    if (!empty($message) && empty($_SESSION[$name])) {
      $_SESSION[$name] = $message;
      $_SESSION[$name . '_class'] = $class;
    } else if (empty($message) && !empty($_SESSION[$name])) {
      $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : $class;
      echo '<div class="' . $class . '">' . $_SESSION[$name] . '</div>';
      unset($_SESSION[$name]);
      unset($_SESSION[$name . '_class']);
    }
  }
}

function redirect($location) {
  header('Location: '.$location);
  exit();
}