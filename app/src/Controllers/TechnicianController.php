<?php

namespace App\Controllers;

use App\Entities\Technician;
use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Lib\Controllers\AbstractController;

require_once __DIR__ . '/../Helpers/session_helper.php';

class TechnicianController extends AbstractController
{
  private $technician;

  public function __construct()
  {
    $this->technician = new Technician();
  }

  public function process(Request $request): Response
  {
    if ($request->isPost() && $request->getPost('type') === 'accept_service_request') {
      $this->acceptServiceRequest($request);
    }

    return new Response('Technician action processed', 200);
  }

  public function acceptServiceRequest(Request $request): Response
  {
    $service_request_id = $request->getPost('service_request_id');
    $technician_id = $request->getPost('technician_id');

    if ($this->technician->acceptServiceRequest($technician_id, $service_request_id)) {
      flash("admin", "Technicien assigné avec succès.");
    } else {
      flash("admin", "Une erreur s'est produite lors de l'assignation du technicien.");
    }
    redirect('/admin/administrative-commands');
  }
}
