<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use App\Repository\TypeRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(BrandRepository $brand_repository, ServiceRepository $service_repository, TypeRepository $type_repository)
    {
        $brands     = $brand_repository->findAll();
        $types      = $type_repository->findAll();
        $breakdowns = $service_repository->findBy(['is_service' => false]);
        $services   = $service_repository->findBy(['is_service' => true]);
        
        return $this->render('page/index.html.twig', [
            'brands'     => $brands,
            'types'      => $types,
            'breakdowns' => $breakdowns,
            'services'   => $services,
        ]);
    }
    
    /**
     * @Route("/price-list/", name="price-list")
     */
    public function price_list(ServiceRepository $service_repository)
    {
        $breakdowns = $service_repository->findBy(['is_service' => false]);
        $services   = $service_repository->findBy(['is_service' => true]);
        
        return $this->render('page/price-list.html.twig', [
            'breakdowns' => $breakdowns,
            'services'   => $services,
        ]);
    }
    /**
     * @Route("/garantiya/", name="garantiya")
     */
    public function garantiya()
    {
        return $this->render('page/garantiya.html.twig');
    }
    /**
     * @Route("/kontakty/", name="contacts")
     */
    public function contacts()
    {
        return $this->render('page/contacts.html.twig');
    }
    /**
     * @Route("/commercial-offer/", name="commercial_offer")
     */
    public function commercial_offer()
    {
        return $this->render('page/commercial_offer.html.twig');
    }
    /**
     * @Route("/restoration/", name="restoration")
     */
    public function restoration()
    {
        return $this->render('page/restoration.html.twig');
    }
}
