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

    
}