<?php

namespace App\Controller;

use App\Repository\TypeRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class TypeController extends AbstractController
{
    
    /**
     * @Route("/type-{type}/", name="type")
     */
    public function item($type, TypeRepository $type_repository, ServiceRepository $service_repository)
    {
        if ( ! $type_entity = $type_repository->findOneBy(['alias' => $type])) {
            throw new NotFoundHttpException();
        }
        $breakdowns = $service_repository->findBy(['is_service' => false]);
        $services   = $service_repository->findBy(['is_service' => true]);
        
        return $this->render('type/index.html.twig', [
            'type' => $type_entity,
            'breakdowns' => $breakdowns,
            'services' => $services,
        ]);
    }
    
    /**
     * @Route("/type-{type}/{service}/", name="type_service")
     */
    public function service(
        $type,
        $service,
        TypeRepository $type_repository,
        ServiceRepository $service_repository
    ) {
        if ( ! $type_entity = $type_repository->findOneBy(['alias' => $type])) {
            throw new NotFoundHttpException();
        }
        $breakdowns = $service_repository->findBy(['is_service' => false]);
        $services   = $service_repository->findBy(['is_service' => true]);
        if ($service_entity = $service_repository->findOneBy(['alias' => $service])) {
            return $this->render('type/service.html.twig', [
                'type' => $type_entity,
                'service' => $service_entity,
                'breakdowns' => $breakdowns,
                'services' => $services,
            ]);
        } else {
            throw new NotFoundHttpException();
        }
        
        
    }
    
}
