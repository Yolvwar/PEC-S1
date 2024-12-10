<?php

require __DIR__ . '/Lib/Database/DatabaseConnexion.php';
require __DIR__ . '/Lib/Database/Dsn.php';

use App\Lib\Database\DatabaseConnexion;

try{
  $dbConnexion = new DatabaseConnexion();
  $dbConnexion->setConnexion();
  $pdo = $dbConnexion->getConnexion();
  echo "Connexion Test Réussie";
 }catch(PDOException $e){
  echo "Connexion échouée: " . $e->getMessage();
 }
