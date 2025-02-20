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
      // Création du contenu HTML de l'email avec style inline pour meilleure compatibilité email
      $emailContent = '
      <div class="email-template" style="background: #f8f9fa; font-family: Arial, sans-serif; line-height: 1.6;">
          <div class="email-template__container" style="max-width: 600px; margin: 0 auto; padding: 2rem;">
              <div class="email-template__content" style="background: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow: hidden;">
                  <div class="email-template__header" style="background: #007bff; padding: 2rem; text-align: center;">
                      <img src="data:image/png;base64,' . base64_encode(file_get_contents(__DIR__ . '/../../sass/images/Doc2Wheels-logo-1.png')) . '" 
                           alt="Logo" 
                           style="height: 60px; margin-bottom: 1rem;">
                      <h1 style="color: white; font-size: 1.5rem; margin: 0;">Bienvenue chez Doc2Wheels !</h1>
                  </div>
                  
                  <div class="email-template__body" style="padding: 2rem;">
                      <p class="welcome" style="color: #212529; font-size: 1.1rem; margin: 0 0 1.5rem 0;">
                          Bonjour ' . htmlspecialchars($data['name']) . ' 👋
                      </p>
                      
                      <p style="color: #212529; margin: 0 0 1rem 0;">
                          Nous sommes ravis de vous accueillir dans la communauté Doc2Wheels ! Pour commencer votre aventure avec nous, 
                          veuillez activer votre compte en cliquant sur le bouton ci-dessous :
                      </p>
                      
                      <div style="text-align: center; margin: 2rem 0;">
                          <a href="/login/account-activation?token=' . $this->user->getActivationToken($data['email']) . '"
                             style="display: inline-block; background: #007bff; color: white; text-decoration: none; 
                                    padding: 0.75rem 2rem; border-radius: 4px; font-weight: 500;">
                              ✨ Activer mon compte ✨
                          </a>
                      </div>
                      
                      <p style="color: #6c757d; font-size: 0.9rem; margin: 1rem 0; text-align: center;">
                          Si le bouton ne fonctionne pas, copiez et collez ce lien dans votre navigateur :
                      </p>
                      <p style="color: #007bff; word-break: break-all; font-size: 0.9rem; margin: 0 0 1rem 0; text-align: center;">
                          /login/account-activation?token=' . $this->user->getActivationToken($data['email']) . '
                      </p>
                  </div>
                  
                  <div class="email-template__footer" style="background: #f8f9fa; padding: 1.5rem; text-align: center; 
                                                            border-top: 1px solid #dee2e6;">
                      <p style="color: #6c757d; font-size: 0.9rem; margin: 0;">
                          Cet email a été envoyé automatiquement par Doc2Wheels. Merci de ne pas y répondre.
                      </p>
                      <p style="color: #6c757d; font-size: 0.8rem; margin: 0.5rem 0 0 0;">
                          © 2025 Doc2Wheels - Tous droits réservés
                      </p>
                  </div>
              </div>
          </div>
      </div>';
      Mail::sendMail(
        $data['email'],
        'Activation de votre compte',
        $emailContent
      );
      redirect('/login');
    } else {
      flash("register", "Une erreur s'est produite lors de l'inscription.");
    }
  }
}
