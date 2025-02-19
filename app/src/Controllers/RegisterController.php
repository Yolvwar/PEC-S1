<?php

namespace App\Controllers;

use App\Entities\User;
use App\Entities\Mail;
use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Lib\Controllers\AbstractController;

require_once __DIR__ . '/../Helpers/session_helper.php';

class RegisterController extends AbstractController
{
  private $user;

  public function __construct()
  {
    $this->user = new User();
  }

  public function process(Request $request): Response
  {
    if ($request->isPost() && $request->getPost('type') === 'register') {
      $this->register($request);
    }


    return $this->render('register', [
      'title' => 'Register Form Page',
    ], 'auth');
  }

  public function register(Request $request)
  {
    // Initialisation des variables utilisées pour l'inscription
    $data = [
      'name' => trim($request->getPost('name')),
      'email' => trim($request->getPost('email')),
      'username' => trim($request->getPost('username')),
      'password' => trim($request->getPost('password')),
      'confirm_password' => trim($request->getPost('confirm_password'))
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
      flash("register", "Veuillez activer votre compte en cliquant sur le lien envoyé à votre adresse email.");
      Mail::sendMail(
        $data['email'],
        'Activation de votre compte',
        "Please activate your account by clicking <a href='http://localhost:8080/login/account-activation?token=" . $this->user->getActivationToken($data['email']) . "'><b>here</b></a>."
      );
      redirect('/login/email-validation');
    } else {
      flash("register", "Une erreur s'est produite lors de l'inscription.");
    }
  }
}
