<?php

namespace App\Entities;

use App\Lib\Database\DatabaseConnexion;

class Location
{
  private $dbConnexion;

  public function __construct()
  {
    $this->dbConnexion = new DatabaseConnexion();
  }

  public function getAll()
  {
    $this->dbConnexion->query("SELECT * FROM locations");
    return $this->dbConnexion->resultSet();
  }
}
