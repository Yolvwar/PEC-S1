<?php

namespace App\Controllers;

use App\Entities\User;
use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Lib\Controllers\AbstractController;

require_once __DIR__ . '/../helpers/session_helper.php';

class RegisterController extends AbstractController
{
  public function process(Request $request): Response
  {
    return $this->render('register', [
      'title' => 'Pouet',
      'items' => ['foo', 'bar', 'baz'],
    ], 'auth');
  }
}
