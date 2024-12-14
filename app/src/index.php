<?php

require __DIR__ . '/Lib/Database/DatabaseConnexion.php';
require __DIR__ . '/Lib/Database/Dsn.php';

require_once __DIR__ . '/../vendor/autoload.php';

?>
<?php
include_once 'views/header/index.php'
?>

<h1 id="index-text">Welcome, <?php if (isset($_SESSION['user_id'])) {
                                echo explode(" ", $_SESSION['user_username'])[0];
                              } else {
                                echo 'Guest';
                              }
                              ?> </h1>


<?php

var_dump($_SESSION);
?>