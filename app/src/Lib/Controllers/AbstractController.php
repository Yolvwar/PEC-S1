<?php

namespace App\Lib\Controllers;

use App\Lib\Http\Request;
use App\Lib\Http\Response;

abstract class AbstractController
{
  abstract public function process(Request $request): Response;

  protected function render(string $template, array $data = [], string $dir = ''): Response
  {
    $response = new Response();
    extract($data);
    ob_start();
    $path = __DIR__ . "/../../Views";
    if ($dir) {
      $path .= "/{$dir}";
    }
    $path .= "/{$template}.view.php";
    require_once $path;
    $response->setContent(ob_get_clean());
    $response->addHeader('Content-Type', 'text/html');

    return $response;
  }
}
