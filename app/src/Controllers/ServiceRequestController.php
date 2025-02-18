<?php

namespace App\Controllers;

use App\Entities\Service;
use App\Entities\Location;
use App\Entities\TimeSlot;
use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Lib\Controllers\AbstractController;

require_once __DIR__ . '/../helpers/session_helper.php';

class ServiceRequestController extends AbstractController
{
    private $service;
    private $location;
    private $timeSlot;

    public function __construct()
    {
        $this->service = new Service();
        $this->location = new Location();
        $this->timeSlot = new TimeSlot();
    }

    public function process(Request $request): Response
    {
        if ($request->isPost() && $request->getPost('type') === 'service_request') {
            $this->createServiceRequest($request);
        }

        return $this->render('service_request', [
            'title' => 'Demande de Réparation',
            'serviceTypes' => $this->service->getServiceTypes(),
            'locations' => $this->location->getLocations(),
            'timeSlots' => $this->timeSlot->getTimeSlots()
        ], 'service');
    }

    public function createServiceRequest(Request $request)
    {

        $data = [
            'user_id' => $_SESSION['user_id'],
            'service_id' => $request->getPost('service_id'),
            'location_id' => $request->getPost('location_id'),
            'time_slot_id' => $request->getPost('time_slot_id'),
            'description' => trim($request->getPost('description'))
        ];

        if (empty($data['service_id']) || empty($data['location_id']) || empty($data['time_slot_id']) || empty($data['description'])) {
            flash("service_request", "Veuillez remplir tous les champs.");
            redirect('/service_request');
        }

        if ($this->service->createServiceRequest($data)) {
            flash("service_request", "Demande de service créée avec succès.");
            redirect('/home');
        } else {
            flash("service_request", "Une erreur s'est produite lors de la création de la demande de service.");
        }
    }
}