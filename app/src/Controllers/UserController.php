<?php

namespace App\Controllers;

use App\Entities\User;
use App\Entities\Service;
use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Lib\Controllers\AbstractController;

require_once __DIR__ . '/../helpers/session_helper.php';

class UserController extends AbstractController
{
    private $user;
    private $service;

    public function __construct()
    {
        $this->user = new User();
        $this->service = new Service();
    }

    public function process(Request $request): Response
    {
        if (!isset($_SESSION['user_id'])) {
            flash("login", "Vous devez être connecté pour voir votre profil.");
            redirect('/login');
            exit();
        }

        $user = $this->user->findUserById($_SESSION['user_id']);

        $serviceRequests = $this->service->getServiceRequestsByUserId($_SESSION['user_id']);

        return $this->render('user_profile', [
            'title' => 'Profil Utilisateur',
            'user' => $user,
            'serviceRequests' => $serviceRequests
        ], 'user');
    }
}