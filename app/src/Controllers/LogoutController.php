<?php

namespace App\Controllers;

use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Lib\Controllers\AbstractController;

require_once __DIR__ . '/../Helpers/session_helper.php';

class LogoutController extends AbstractController
{
  public function process(Request $request): Response {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_username']);
    session_destroy();
    redirect('/login');
  }
}
