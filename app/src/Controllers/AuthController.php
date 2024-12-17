<?php

namespace App\Controllers;

use App\Entities\User;

require_once __DIR__ . '/../helpers/session_helper.php';
require_once __DIR__ . '/../../vendor/autoload.php';


class AuthController
{

  private $user;

  public function __construct()
  {
    $this->user = new User();
  }

  public function register()
  {

    // Initialisation des variables utilisées pour l'inscription
    $data = [
      'name' => trim($_POST['name']),
      'email' => trim($_POST['email']),
      'username' => trim($_POST['username']),
      'password' => trim($_POST['password']),
      'confirm_password' => trim($_POST['confirm_password'])
    ];

    // Validation des données & vérification si champs vides
    if (empty($data['name']) || empty($data['email']) || empty($data['username']) || empty($data['password']) || empty($data['confirm_password'])) {
      flash("register", "Veuillez remplir tous les champs.");
      redirect('/register');
    }

    if (!preg_match("/^[a-zA-Z0-9]*$/", $data['username'])) {
      flash("register", "Nom d'utilisateur invalide.");
      redirect('/register');
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      flash("register", "Email invalide.");
      redirect('/register');
    }

    if (strlen($data['password']) < 6) {
      flash("register", "Le mot de passe doit contenir au moins 6 caractères.");
      redirect('/register');
    } else if ($data['password'] !== $data['confirm_password']) {
      flash("register", "Les mots de passe ne correspondent pas.");
      redirect('/register');
    }

    // Vérification si l'utilisateur existe déjà

    if ($this->user->findUserByEmailOrUsername($data['email'], $data['username'])) {
      flash("register", "Cet email ou ce nom d'utilisateur existe déjà.");
      redirect('/register');
    }

    // Hash du mot de passe
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

    // Enregistrement de l'utilisateur
    if ($this->user->registerUser($data)) {
      flash("register", "Inscription effectuée avec succès.");
      redirect('/login');
    } else {
      flash("register", "Une erreur s'est produite lors de l'inscription.");
    }
  }

  public function login()
  {

    // Initialisation des variables utilisées pour la connexion
    $data = [
      'name/email' => trim($_POST['name/email']),
      'password' => trim($_POST['password'])
    ];

    // Vérification si champs vides
    if (empty($data['name/email']) || empty($data['password'])) {
      flash("login", "Veuillez remplir tous les champs.");
      redirect('/login');
      exit();
    }

    // Vérification si l'utilisateur existe
    if ($this->user->findUserByEmailOrUsername($data['name/email'], $data['name/email'])) {
      // Utilisateur trouvé
      $loggedInUser = $this->user->loginUser($data['name/email'], $data['password']);

      // Si utilisateur trouvé, créer une session utilisateur
      if ($loggedInUser) {
        // Créer une session utilisateur
        $this->createUserSession($loggedInUser);
      } else {
        flash("login", "Nom d'utilisateur ou mot de passe incorrect.");
        redirect('/login');
      }
    } else {
      flash("login", "Utilisateur non trouvé.");
      redirect('/login');
    }
  }

  // Créer une session utilisateur après la connexion pour récupérer les données de l'utilisateur
  public function createUserSession($user)
  {
    $_SESSION['user_id'] = $user->id;
    $_SESSION['user_email'] = $user->email;
    $_SESSION['user_username'] = $user->username;
    redirect('/home');
  }

  // Déconnexion de l'utilisateur et destruction de la session
  public function logout()
  {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_username']);
    session_destroy();
    redirect('/login');
  }
}

$init = new AuthController();

// S'assure que le user envoie une requête POST

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  switch ($_POST['type']) {
    case 'register':
      $init->register();
      break;
    case 'login':
      $init->login();
      break;
    case 'logout':
      $init->logout();
      break;
  } 
}
