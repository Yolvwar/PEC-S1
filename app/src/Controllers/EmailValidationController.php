<?php

namespace App\Controllers;

use App\Entities\User;
use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Lib\Controllers\AbstractController;

require_once __DIR__ . '/../helpers/session_helper.php';

class EmailValidationController extends AbstractController
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function process(Request $request): Response
    {   
        $this->activatedAccountRender($request);
        $this->emailValidation($request);

        return $this->render('account-activation', [
            'title' => 'Email Validation Page',
        ], 'auth');
    }

    public function emailValidation(Request $request)
    {
        // Vérif si utilisateur token présent dans l'url
        $params = $request->getUrlParams();

        if (isset($params['token']) && $params['token'] != '') {
            $this->user->activateAccount($params['token']);
        } else {
            flash("login", "Token invalide.");
        }
    }

    public function activatedAccountRender(Request $request)
    {
        if ($this->user->isActivated($request->getUrlParams()['token'])) {
            flash("login", "Compte activé avec succès.");
        } else {
            flash("login", "Token invalide.");
        }
    }
}
