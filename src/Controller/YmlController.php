<?php

namespace App\Controller;

use App\Service\YmlGeneratorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class YmlController extends AbstractController
{
    /**
     * @Route("/yml", name="yml", defaults={"_format"="xml"})
     */
    public function index(YmlGeneratorService $yml_generator)
    {
        $date = date("Y-m-d H:i", time());
        $offers = $yml_generator->getOffers();
        
        
        return $this->render('yml/index.xml.twig', [
            'date' => $date,
            'offers' => $offers,
        ]);
    }
    
}
