<?php

namespace App\Controllers\AdminControllers;

use App\Entities\User;
use App\Entities\Service;
use App\Entities\ServiceRequest;
use App\Entities\Technician;
use App\Entities\Location;
use App\Entities\TimeSlot;
use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Entities\Mail;
use App\Lib\Controllers\AbstractController;

require_once __DIR__ . '/../../Helpers/session_helper.php';

class AdminController extends AbstractController
{
  private $userModel;
  private $service;
  private $serviceRequestModel;
  private $technicianModel;
  private $location;
  private $timeSlot;
  private $mail;

  public function __construct()
  {
    $this->userModel = new User();
    $this->service = new Service();
    $this->location = new Location();
    $this->serviceRequestModel = new ServiceRequest();
    $this->technicianModel = new Technician();
    $this->timeSlot = new TimeSlot();
    $this->mail = new Mail();
  }

  public function process(Request $request): Response
  {

    $users = $this->userModel->getAll();
    $services = $this->serviceRequestModel->getAll();
    $technicians = $this->technicianModel->getAll();
    //$timeSlots = $this->timeSlot->getTimeSlots();

    return $this->render('dashboard', [
      'title' => 'Tableau de Bord Admin',
      'users' => $users,
      'services' => $services,
      'technicians' => $technicians
      //'timeSlots' => $timeSlots
    ], 'admin');
  }

    // -----------------User-----------------

  public function manageUsers(Request $request): Response
  {
        $users = $this->userModel->getAll();
        return $this->render('admin/users/index', ['users' => $users]);
  }

  public function createUser(Request $request): Response
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->userModel->create($_POST);
      header('Location: /admin/users');
      exit;
    }
    return $this->render('admin/users/create');
  }

  public function editUser(Request $request, $id): Response
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->userModel->update($id, $_POST);
      header('Location: /admin/users');
      exit;
    }
    $user = $this->userModel->getById($id);
    return $this->render('admin/users/edit', ['user' => $user]);
  }

  public function deleteUser(Request $request, $id): Response
  {
    $this->userModel->delete($id);
    header('Location: /admin/users');
    exit;
  }

    // -----------------Technician-----------------

    public function manageTechnicians(Request $request): Response
    {
        $technicians = $this->technicianModel->getAll();
        return $this->render('admin/technicians/index', ['technicians' => $technicians]);
    }

    public function createTechnician(Request $request): Response
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->technicianModel->create($_POST);
            header('Location: /admin/technicians');
            exit;
        }
        return $this->render('admin/technicians/create');
    }

    public function editTechnician(Request $request, $id): Response
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->technicianModel->update($id, $_POST);
            header('Location: /admin/technicians');
            exit;
        }
        $technician = $this->technicianModel->getById($id);
        $location = $this->location->getById($technician->location_id);
        return $this->render('admin/technicians/edit', [
          'technician' => $technician,
          'location' => $location
      ]);
    }

    public function deleteTechnician(Request $request, $id): Response
  {
    $this->technicianModel->delete($id);
    header('Location: /admin/technicians');
    exit;
  }

  // -----------------ServiceRequest-----------------


  public function manageServiceRequests(Request $request): Response
  {
    $service_requests = $this->serviceRequestModel->getAll();
    $technicians = $this->technicianModel->getAvailibleTechnicians();
    return $this->render('admin/service_requests/index', [
      'service_requests' => $service_requests,
      'technicians' => $technicians
  ]);
  }

  public function createServiceRequest(Request $request): Response
  {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $data = $_POST;
          if ($data['location_id'] === 'custom') {
              $location_id = $this->location->create('Custom Address', $data['custom_address']);
              $data['location_id'] = $location_id;
          }
          $this->serviceRequestModel->create($data);
          header('Location: /admin/service_requests');
          exit;
      }

      $users = $this->userModel->getAll();
      $services = $this->service->getAll();
      $locations = $this->location->getAll();
      $timeSlots = $this->timeSlot->getAll();

      return $this->render('admin/service_requests/create', [
          'users' => $users,
          'services' => $services,
          'locations' => $locations,
          'timeSlots' => $timeSlots
      ]);
  }

  public function editServiceRequest(Request $request, $id): Response
  {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $this->serviceRequestModel->update($id, $_POST);
          header('Location: /admin/service_requests');
          exit;
      }
      $user = $this->userModel->getById($id);
      $serviceRequest = $this->serviceRequestModel->getById($id);
      $services = $this->service->getAll();
      $locations = $this->location->getAll();
      $timeSlots = $this->timeSlot->getAll();
      return $this->render('admin/service_requests/edit', [
          'user' => $user,
          'service_request' => $serviceRequest,
          'services' => $services,
          'locations' => $locations,
          'timeSlots' => $timeSlots
      ]);
  }

  public function deleteServiceRequest(Request $request, $id): Response
  {
    $this->serviceRequestModel->delete($id);
    header('Location: /admin/service_requests');
    exit;
  }

  public function completeServiceRequest(Request $request, $id): Response
  {
    $this->serviceRequestModel->complete($id);
    header('Location: /admin/service_requests');
    exit;
  }

  public function assignTechnician(Request $request, $id): Response
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $technician_id = $request->getPost('technician_id');
            $this->serviceRequestModel->assignTechnician($id, $technician_id);

            // Récupérer les informations de la demande de service et de l'utilisateur
            $service_request = $this->serviceRequestModel->getById($id);
            $user = $this->userModel->getById($service_request->user_id);

            // Envoyer un email à l'utilisateur
            $this->mail->sendServiceRequestAcceptedMail($user, $service_request);

            header('Location: /admin/service_requests');
            exit;
        }
        $service_request = $this->serviceRequestModel->getById($id);
        $technicians = $this->technicianModel->getAll();

        return $this->render('admin/service_requests/assign_technician', [
            'service_request' => $service_request,
            'technicians' => $technicians
        ]);
    }

  // -----------------Services-----------------

  public function manageServices(Request $request): Response
  {
    $services = $this->service->getAll();
    return $this->render('admin/services/index', ['services' => $services]);
  }

  public function createService(Request $request): Response
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->service->create($_POST);
      header('Location: /admin/services');
      exit;
    }
    return $this->render('admin/services/create');
  }

  public function editService(Request $request, $id): Response
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->service->update($id, $_POST);
      header('Location: /admin/services');
      exit;
    }
    $service = $this->service->getById($id);
    return $this->render('admin/services/edit', ['service' => $service]);
  }

  public function deleteService(Request $request, $id): Response
  {
    $this->service->delete($id);
    header('Location: /admin/services');
    exit;
  }



}