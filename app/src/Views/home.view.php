<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Login System</title>
  <link rel="stylesheet" href="./style.css" type="text/css">
</head>

<body>
  <nav>
    <ul>
      <a href="/home">
        <li>Home</li>
      </a>
      <p>Welcome <?php if (isset($_SESSION['user_id'])) {echo explode(" ", $_SESSION['user_username'])[0];} else {echo 'Guest';} ?></p>
      <?php if (!isset($_SESSION['user_id'])) : ?>
        <a href="register">
          <li>Sign Up</li>
        </a>
        <a href="login">
          <li>Login</li>
        </a>
      <?php else: ?>
        <a href="logout">
          <li>Logout</li>
        </a>
      <?php endif; ?>
    </ul>
  </nav>