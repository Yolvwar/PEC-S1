<?php

namespace App\Controllers;

use App\Entities\User;
use App\Entities\Service;
use App\Entities\ServiceRequest;
use App\Entities\Evaluation;
use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Lib\Controllers\AbstractController;

require_once __DIR__ . '/../Helpers/session_helper.php';

class UserController extends AbstractController
{
  private $user;
  private $serviceRequest;
  private $evaluation;

  public function __construct()
  {
    $this->user = new User();
    $this->serviceRequest = new ServiceRequest();
    $this->evaluation = new Evaluation();
  }

  public function process(Request $request): Response
  {
    if (!isset($_SESSION['user_id'])) {
      flash("login", "Vous devez être connecté pour voir votre profil.");
      redirect('/login');
      exit();
    }

    $user = $this->user->findUserById($_SESSION['user_id']);

    $serviceRequests = $this->serviceRequest->getServiceRequestsByUserId($_SESSION['user_id']);

    $evaluations = [];
    foreach ($serviceRequests as $request) {
      $evaluations[$request->id] = $this->evaluation->getEvaluationsByServiceRequestId($request->id);
    }

    return $this->render('user_profile', [
      'title' => 'Profil Utilisateur',
      'user' => $user,
      'serviceRequests' => $serviceRequests,
      'evaluations' => $evaluations
    ], 'user');
  }

  public function paramsRender(Request $request): Response
  {
    return $this->render('user_param', [
      'title' => 'Paramètres',
    ], 'user');
  }
}
