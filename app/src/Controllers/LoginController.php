<?php

namespace App\Controllers;

use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Lib\Controllers\AbstractController;

class LoginController extends AbstractController {


    public function process(Request $request): Response {
        return $this->render('login', [
            'title' => 'Login Form Page',
            'items' => ['foo', 'bar', 'baz'],
        ], 'auth');;
    }
}