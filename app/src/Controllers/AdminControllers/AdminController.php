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
use App\Entities\Devis;
use App\Entities\Mail;
use App\Entities\Evaluation;
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
  private $devis;
  private $evaluation;

  public function __construct()
  {
    $this->userModel = new User();
    $this->service = new Service();
    $this->location = new Location();
    $this->serviceRequestModel = new ServiceRequest();
    $this->technicianModel = new Technician();
    $this->timeSlot = new TimeSlot();
    $this->mail = new Mail();
    $this->devis = new Devis();
    $this->evaluation = new Evaluation();
  }

  public function process(Request $request): Response
  {

    $users = $this->userModel->getAll();
    $services = $this->serviceRequestModel->getAll();
    $technicians = $this->technicianModel->getAll();
    //$timeSlots = $this->timeSlot->getTimeSlots();

    $numberOfInterventions = $this->serviceRequestModel->countAll();
    $customerSatisfaction = $this->evaluation->averageSatisfaction();
    $completedRate = $this->serviceRequestModel->calculateCompletedRate();
    $revenueGenerated = $this->serviceRequestModel->calculateRevenue();
    $revenueByTechnician = $this->serviceRequestModel->calculateRevenueByTechnician();
    $pendingInterventions = $this->serviceRequestModel->countPending();

    $lastMonthStart = date('Y-m-01', strtotime('first day of last month'));
    $lastMonthEnd = date('Y-m-t', strtotime('last day of last month'));
    $lastYearStart = date('Y-01-01', strtotime('first day of January last year'));
    $lastYearEnd = date('Y-12-31', strtotime('last day of December last year'));
    $thisMonthStart = date('Y-m-01');
    $thisMonthEnd = date('Y-m-t');

    $revenueLastMonth = $this->serviceRequestModel->calculateRevenueByPeriod($lastMonthStart, $lastMonthEnd);
    $revenueLastYear = $this->serviceRequestModel->calculateRevenueByPeriod($lastYearStart, $lastYearEnd);
    $revenueThisMonth = $this->serviceRequestModel->calculateRevenueByPeriod($thisMonthStart, $thisMonthEnd);

    // data pour les charts
    $interventionsData = $this->serviceRequestModel->getInterventionsDataByMonth();
    $revenueData = $this->serviceRequestModel->getRevenueDataByMonth();

    return $this->render('dashboard', [
      'title' => 'Tableau de Bord Admin',
      'users' => $users,
      'services' => $services,
      'technicians' => $technicians,
      'numberOfInterventions' => $numberOfInterventions,
      'customerSatisfaction' => $customerSatisfaction,
      'completedRate' => $completedRate,
      'revenueGenerated' => $revenueGenerated,
      'revenueByTechnician' => $revenueByTechnician,
      'pendingInterventions' => $pendingInterventions,
      'revenueLastMonth' => $revenueLastMonth,
      'revenueLastYear' => $revenueLastYear,
      'revenueThisMonth' => $revenueThisMonth,
      'interventionsData' => $interventionsData,
      'revenueData' => $revenueData
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
    $serviceRequest = $this->serviceRequestModel->getById($id);
    $user = $this->userModel->getById($serviceRequest->user_id);
    $location = $this->location->getById($serviceRequest->location_id);
    $services = $this->service->getAll();
    $timeSlots = $this->timeSlot->getAll();
    $technicians = $this->technicianModel->getAll();
    return $this->render('admin/service_requests/edit', [
        'user' => $user,
        'service_request' => $serviceRequest,
        'location' => $location,
        'services' => $services,
        'technicians' => $technicians,
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

            $service_request = $this->serviceRequestModel->getById($id);
            $user = $this->userModel->getById($service_request->user_id);
            $technician = $this->technicianModel->getById($technician_id);

            // Envoyer un email à l'utilisateur
            $this->mail->sendServiceRequestAcceptedMail($user, $service_request);

            // Reevaluer le prix estimé
              $devis = new Devis();
              $preliminaryEstimate = $devis->getPreliminaryEstimateByServiceRequestId($id);
              
              $final_estimate = $devis->calculateFinalEstimate($service_request->user_location, $technician->location, $preliminaryEstimate);
              $devis->updateEstimate($service_request->id, $final_estimate);

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