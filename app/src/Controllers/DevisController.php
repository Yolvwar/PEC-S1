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

    
}