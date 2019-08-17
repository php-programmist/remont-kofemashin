<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(BrandRepository $brand_repository, ServiceRepository $service_repository)
    {
        $brands     = $brand_repository->findAll();
        $breakdowns = $service_repository->findBy(['is_service' => false]);
        $services   = $service_repository->findBy(['is_service' => true]);
        
        return $this->render('page/index.html.twig', [
            'brands'     => $brands,
            'breakdowns' => $breakdowns,
            'services'   => $services,
        ]);
    }
}
