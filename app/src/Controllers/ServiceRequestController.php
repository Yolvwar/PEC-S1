<?php

namespace App\Controllers;

use App\Entities\Service;
use App\Entities\ServiceRequest;
use App\Entities\Technician;
use App\Entities\Evaluation;
use App\Entities\Location;
use App\Entities\TimeSlot;
use App\Entities\Devis;
use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Lib\Controllers\AbstractController;

require_once __DIR__ . '/../Helpers/session_helper.php';

class ServiceRequestController extends AbstractController
{
  private $service;
  private $serviceRequest;
  private $technician;
  private $evaluation;
  private $location;
  private $timeSlot;
  private $devis;

  public function __construct()
  {
    $this->service = new Service();
    $this->serviceRequest = new ServiceRequest();
    $this->technician = new Technician();
    $this->evaluation = new Evaluation();
    $this->location = new Location();
    $this->timeSlot = new TimeSlot();
    $this->devis = new Devis();
  }

  public function process(Request $request): Response
  {
    if ($request->isPost()) {
      $type = $request->getPost('type');
      if ($type === 'create_service_request') {
        $this->createServiceRequest($request);
      } elseif ($type === 'add_evaluation') {
        $this->addEvaluation($request);
      }
    }

    return $this->render('service_request', [
      'title' => 'Demande de Réparation',
      'serviceTypes' => $this->service->getAll(),
      'locations' => $this->location->getAll(),
      'timeSlots' => $this->timeSlot->getAll(),
      'technicians' => $this->technician->getAll()
    ], 'service');
  }

  public function createServiceRequest(Request $request)
{
    $data = [
        'user_id' => $_SESSION['user_id'],
        'service_id' => $request->getPost('service_id'),
        'vehicle_type' => $request->getPost('vehicle_type'),
        'location_street' => $request->getPost('location_street'),
        'location_address' => $request->getPost('location_address'),
        'location_city' => $request->getPost('location_city'),
        'location_postal_code' => $request->getPost('location_postal_code'),
        'time_slot_id' => $request->getPost('time_slot_id'),
        'description' => trim($request->getPost('description'))
    ];

    if (empty($data['service_id']) || empty($data['location_street']) || empty($data['location_address']) || empty($data['location_city']) || empty($data['location_postal_code']) || empty($data['time_slot_id']) || empty($data['description'])) {
        flash("service_request", "Veuillez remplir tous les champs.");
        redirect('/service_request');
    }

    $location_id = $this->location->createAndReturnId($data['location_street'], $data['location_address'], $data['location_city'], $data['location_postal_code']);
    $data['location_id'] = $location_id;

    $data['preliminary_estimate'] = $this->devis->calculatePreliminaryEstimate($data['service_id'], $data['vehicle_type']);

    if ($this->serviceRequest->create($data)) {

        $service_request_id = $this->serviceRequest->getLastInsertId();

        $devis_data = [
            'service_request_id' => $service_request_id,
            'preliminary_estimate' => $data['preliminary_estimate']
        ];

        $this->devis->create($devis_data);

        flash("service_request", "Demande de service créée avec succès.");
        redirect('/home');
    } else {
        flash("service_request", "Une erreur s'est produite lors de la création de la demande de service.");
    }
}

  

  public function addEvaluation(Request $request)
  {
    $data = [
      'service_request_id' => $request->getPost('service_request_id'),
      'rating' => $request->getPost('rating'),
      'comment' => trim($request->getPost('comment'))
    ];

    if (empty($data['service_request_id']) || empty($data['rating']) || empty($data['comment'])) {
      flash("evaluation", "Veuillez remplir tous les champs.");
      redirect('/user/profile');
    }

    $serviceRequest = $this->serviceRequest->getServiceRequestById($data['service_request_id']);
    if (!$serviceRequest) {
      flash("evaluation", "Demande de service non trouvée.");
      redirect('/user/profile');
    }

    if (!$this->serviceRequest->isServiceRequestCompleted($data['service_request_id'])) {
      flash("evaluation", "Vous ne pouvez pas évaluer une demande de service non terminée.");
      redirect('/user/profile');
    }

    if ($this->evaluation->evaluationExists($data['service_request_id'])) {
      flash("evaluation", "Vous avez déjà évalué cette demande de service.");
      redirect('/user/profile');
    }

    if ($this->evaluation->addEvaluation($data)) {
      flash("evaluation", "Évaluation ajoutée avec succès.");
      redirect('/user/profile');
    } else {
      flash("evaluation", "Une erreur s'est produite lors de l'ajout de l'évaluation.");
      redirect('/user/profile');
    }
  }

  public function confirmedServiceRequest(Request $request): Response
  {
    $service_request_id = $request->getPost('service_request_id');
    $this->serviceRequest->confirmServiceRequest($service_request_id);
    redirect('/home');
  }

  
}