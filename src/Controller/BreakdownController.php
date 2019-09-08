<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class BreakdownController extends AbstractController
{
    /**
     * @Route("/neispravnosti/", name="breakdown_index")
     */
    public function index( ServiceRepository $service_repository)
    {
        $breakdowns = $service_repository->findBy(['is_service' => false]);
        
        return $this->render('breakdown/index.html.twig', [
            'breakdowns' => $breakdowns,
        ]);
    }
    
    /**
     * @Route("/neispravnosti/{breakdown}/", name="breakdown_item")
     */
    public function item(
        $breakdown,
        ServiceRepository $service_repository
    ) {
        if ( ! $service = $service_repository->findOneBy(['alias' => $breakdown])) {
            throw new NotFoundHttpException();
        }
        return $this->render('breakdown/item.html.twig', [
            'service' => $service,
        ]);
    }
    
}
