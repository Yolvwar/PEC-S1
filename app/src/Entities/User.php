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

  // Méthode pour récupérer le account_activation_hash de l'utilisateur

  public function getActivationToken($email)
  {
    $this->dbConnexion->query("SELECT account_activation_hash FROM users WHERE email = :email");
    $this->dbConnexion->bind(':email', $email);

    $row = $this->dbConnexion->single();

    // Check row
    if ($this->dbConnexion->rowCount() > 0) {
      return $row->account_activation_hash;
    } else {
      return false;
    }
  }

  // Méthode pour enregistrer un utilisateur
  public function registerUser($data)
  {
    $activation_token_hash = $this->generateActivationToken();

    $this->dbConnexion->query(
      "INSERT INTO users (name, email, username, password, account_activation_hash) 
       VALUES (:name, :email, :username, :password, :account_activation_hash)"
    );

    //bind values
    $this->dbConnexion->bind(':name', $data['name']);
    $this->dbConnexion->bind(':email', $data['email']);
    $this->dbConnexion->bind(':username', $data['username']);
    $this->dbConnexion->bind(':password', $data['password']);
    $this->dbConnexion->bind(':account_activation_hash', $activation_token_hash);

    //execute
    if ($this->dbConnexion->execute()) {
      return true;
    } else {
      return false;
    }
  }

  // Méthode pour connecter un utilisateur
  public function loginUser($nameOrEmail, $password)
  {
    $row = $this->findUserByEmailOrUsername($nameOrEmail, $nameOrEmail);

    if ($row == false) {
      return false;
    }

    // On vérifie si le mot de passe correspond avec le mot de passe hashé
    $hashed_password = $row->password;
    if (password_verify($password, $hashed_password)) {
      return $row;
    } else {
      return false;
    }
  }

  // user activation token
  public function generateActivationToken($length = 16)
  {
    $activation_token = bin2hex(random_bytes($length));
    return hash('sha256', $activation_token);
  }

  public function activateAccount($token)
  {
    $this->dbConnexion->query("UPDATE users SET account_activation_hash = NULL WHERE account_activation_hash = :token");
    $this->dbConnexion->bind(':token', $token);
    if ($this->dbConnexion->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function logoutUser()
  {
    session_destroy();
  }

  public function isActivated($token)
  {
    $this->dbConnexion->query("SELECT account_activation_hash FROM users WHERE account_activation_hash = :token");
    $this->dbConnexion->bind(':token', $token);
    $row = $this->dbConnexion->single();
    if ($this->dbConnexion->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }
}
