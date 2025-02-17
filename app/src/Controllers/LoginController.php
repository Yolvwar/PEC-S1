<?php

namespace App\Controllers;

use App\Entities\User;
use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Lib\Controllers\AbstractController;

require_once __DIR__ . '/../helpers/session_helper.php';

class LoginController extends AbstractController
{
  private $user;

  public function __construct()
  {
    $this->user = new User();
  }

  public function process(Request $request): Response
  {
    if ($request->isPost() && $request->getPost('type') === 'login') {
      $this->login($request);
    }

    return $this->render('login', [
      'title' => 'Login Form Page',
    ], 'auth');
  }

  public function login(Request $request)
  {
    // Initialisation des variables utilisées pour la connexion
    $data = [
      'name/email' => trim($request->getPost('name/email')),
      'password' => trim($request->getPost('password'))
    ];

    // Vérification si champs vides
    if (empty($data['name/email']) || empty($data['password'])) {
      flash("login", "Veuillez remplir tous les champs.");
      redirect('/login');
      exit();
    }

    // Vérification si l'utilisateur existe
    if ($this->user->findUserByEmailOrUsername($data['name/email'], $data['name/email'])) {

      // Verif token activation

      $activation_token = $this->user->getActivationToken($data['name/email']);

      if ($activation_token) {
        flash("login", "Veuillez activer votre compte avant de vous connecter.");
        redirect('/login');
        exit();
      }

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
}
