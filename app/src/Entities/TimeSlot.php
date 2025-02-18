<?php

namespace App\Entities;

use App\Lib\Database\DatabaseConnexion;

class TimeSlot
{
  private $dbConnexion;

  public function __construct()
  {
    $this->dbConnexion = new DatabaseConnexion();
  }

  public function getTimeSlots()
  {
    $this->dbConnexion->query("SELECT * FROM time_slots");
    return $this->dbConnexion->resultSet();
  }
}
