<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use App\Service\MarkerReplaceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DiagnosticController extends AbstractController
{
    /**
     * @Route("/diagnostika/", name="diagnostics_index")
     */
    public function index( ServiceRepository $service_repository)
    {
        $services = $service_repository->findBy(['is_service' => true]);
        
        return $this->render('diagnostics/index.html.twig', [
            'services' => $services,
        ]);
    }
    
    /**
     * @Route("/diagnostika/{service}/", name="diagnostics_item")
     */
    public function item(
        $service,
        ServiceRepository $service_repository,
        MarkerReplaceService $marker_replace_service
    ) {
        if ( ! $service_entity = $service_repository->findOneBy(['alias' => $service])) {
            throw new NotFoundHttpException();
        }
        return $this->render('diagnostics/item.html.twig', [
            'service' => $marker_replace_service->replaceMarkerBrandInOneService($service_entity, ''),
        ]);
    }
}
