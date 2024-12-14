<?php

namespace App\Entities;

use App\Lib\Database\DatabaseConnexion;

class User
{
  private $dbConnexion;

  public function __construct()
  {
    $this->dbConnexion = new DatabaseConnexion();
  }

  // Méthode pour trouver un utilisateur par son email ou son nom d'utilisateur
  public function findUserByEmailOrUsername($email, $username)
  {
    $this->dbConnexion->query("SELECT * FROM users WHERE email = :email OR username = :username");
    $this->dbConnexion->bind(':username', $username);
    $this->dbConnexion->bind(':email', $email);

    $row = $this->dbConnexion->single();

    // Check row
    if ($this->dbConnexion->rowCount() > 0) {
      return $row;
    } else {
      return false;
    }
  }

  // Méthode pour enregistrer un utilisateur
  public function registerUser($data)
  {
    $this->dbConnexion->query(
      "INSERT INTO users (name, email, username, password) 
       VALUES (:name, :email, :username, :password)"
    );

    //bind values
    $this->dbConnexion->bind(':name', $data['name']);
    $this->dbConnexion->bind(':email', $data['email']);
    $this->dbConnexion->bind(':username', $data['username']);
    $this->dbConnexion->bind(':password', $data['password']);

    //execute
    if ($this->dbConnexion->execute()) {
      return true;
    } else {
      return false;
    }
  }

  // Méthode pour connecter un utilisateur
  public function loginUser($nameOrEmail, $password){
    $row = $this->findUserByEmailOrUsername($nameOrEmail, $nameOrEmail);

    if($row == false){
      return false;
    }
    
    // On vérifie si le mot de passe correspond avec le mot de passe hashé
    $hashed_password = $row->password;
    if(password_verify($password, $hashed_password)){
      return $row;
    } else {
      return false;
    }
  }
}
