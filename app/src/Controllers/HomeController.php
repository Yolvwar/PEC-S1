<?php

namespace App\Controllers;

use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Lib\Controllers\AbstractController;

class HomeController extends AbstractController {


    public function process(Request $request): Response {
        return $this->render('home', [
            'title' => 'Home Welcome',
            'items' => ['foo', 'bar', 'baz'],
        ]);;
    }
}