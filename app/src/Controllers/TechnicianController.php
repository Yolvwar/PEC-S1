<?php

namespace App\Controllers;

use App\Entities\Technician;
use App\Entities\Location;
use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Lib\Controllers\AbstractController;

require_once __DIR__ . '/../Helpers/session_helper.php';

class TechnicianController extends AbstractController
{
  private $technician;
  private $location;

  public function __construct()
  {
    $this->technician = new Technician();
    $this->location = new Location();
  }

  public function process(Request $request): Response
  {
    if ($request->isPost() && $request->getPost('type') === 'accept_service_request') {
      $this->acceptServiceRequest($request);
    }

    return new Response('Technician action processed', 200);
  }


public function updateTechnician(Request $request, $id)
{
    $data = [
        'name' => $request->getPost('name'),
        'email' => $request->getPost('email'),
        'speciality' => $request->getPost('speciality'),
        'location_id' => $request->getPost('location_id')
    ];

    if ($this->technician->update($id, $data)) {
        flash("technician", "Technicien mis à jour avec succès.");
        redirect('/admin/technicians');
    } else {
        flash("technician", "Une erreur s'est produite lors de la mise à jour du technicien.");
        redirect('/admin/technicians/edit/' . $id);
    }
}

public function createTechnician(Request $request)
{
  $location_data = [
      'street' => $request->getPost('location_street'),
      'address' => $request->getPost('location_address'),
      'city' => $request->getPost('location_city'),
      'postal_code' => $request->getPost('location_postal_code')
  ];

  $location_id = $this->location->createAndReturnId(
      $location_data['street'],
      $location_data['address'],
      $location_data['city'],
      $location_data['postal_code']
  );

  if (!$location_id) {
      flash("technician", "Erreur lors de la création de la location.");
      redirect('/admin/technicians/create');
      return;
  }

  $data = [
      'name' => $request->getPost('name'),
      'email' => $request->getPost('email'),
      'speciality' => $request->getPost('speciality'),
      'phone' => $request->getPost('phone'),
      'status' => $request->getPost('status'),
      'experience' => $request->getPost('experience'),
      'location_id' => $location_id
  ];

  if ($this->technician->create($data)) {
      flash("technician", "Technicien créé avec succès.");
      redirect('/admin/technicians');
  } else {
      flash("technician", "Une erreur s'est produite lors de la création du technicien.");
      redirect('/admin/technicians/create');
  }
}

}
