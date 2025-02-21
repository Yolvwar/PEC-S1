<?php 

namespace App\Controllers;

use App\Entities\Devis;
use App\Entities\Service;
use App\Entities\Location;
use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Lib\Controllers\AbstractController;

class DevisController extends AbstractController
{
    private $devis;
    private $service;
    private $location;
    
    public function __construct()
    {
        $this->devis = new Devis();
        $this->service = new Service();
        $this->location = new Location();
    }

    public function process(Request $request): Response
    {

        return $this->render('user_devis', [
            'title' => 'Créer un devis',
            'services' => $this->service->getAll(),
            'locations' => $this->location->getAll(),
            'devis' => $this->devis->getDevisByUserId($_SESSION['user_id'])

        ], 'user');
    }

    public function devis(Request $request): Response
    {
        $adressFrom = "Paris, France";
        $adressTo = "Lyon, France";

        $devis = $this->devis->getDistanceBetweenCities($adressFrom, $adressTo);

        $test = $this->devis->calculateFinalEstimate($adressFrom, $adressTo);

        return $this->render('devis', [
            'title' => 'Créer un devis',
            'devis' => $devis,
            'test' => $test
        ], 'test');
    }
    
}