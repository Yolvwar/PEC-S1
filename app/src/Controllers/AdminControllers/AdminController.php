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

  public function __construct()
  {
    $this->userModel = new User();
    $this->service = new Service();
    $this->location = new Location();
    $this->serviceRequestModel = new ServiceRequest();
    $this->technicianModel = new Technician();
    $this->timeSlot = new TimeSlot();
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
        return $this->render('admin/technicians/edit', ['technician' => $technician]);
    }

    public function deleteTechnician(Request $request, $id): Response
  {
    $this->technicianModel->delete($id);
    header('Location: /admin/technicians');
    exit;
  }

  private function assignTechnician(Request $request): Response
  {
    $service_request_id = $request->getPost('service_request_id');
    $technician_id = $request->getPost('technician_id');

    if ($this->technician->acceptServiceRequest($technician_id, $service_request_id)) {
      flash("admin", "Technicien assigné avec succès.");
    } else {
      flash("admin", "Une erreur s'est produite lors de l'assignation du technicien.");
    }

    redirect('/admin');
  }

    // -----------------ServiceRequest-----------------


  public function manageServiceRequests(Request $request): Response
  {
    $service_requests = $this->serviceRequestModel->getAll();
    return $this->render('admin/service_requests/index', ['service_requests' => $service_requests]);
  }

  public function createServiceRequest(Request $request): Response
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->serviceRequestModel->create($_POST);
      header('Location: /admin/service_requests');
      exit;
    }
    return $this->render('admin/service_requests/create');
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
      $services = $this->service->getServiceTypes();
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