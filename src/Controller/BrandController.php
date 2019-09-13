<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Service;
use App\Repository\BrandRepository;
use App\Repository\ModelRepository;
use App\Repository\ServiceRepository;
use App\Service\MarkerReplaceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class BrandController extends AbstractController
{
    /**
     * @Route("/obsluzhivaem-brendy/", name="brands_index")
     */
    public function index(BrandRepository $brand_repository)
    {
        
        $brands = $brand_repository->findAll();
        
        return $this->render('brand/list.html.twig', [
            'brands' => $brands,
        ]);
    }
    
    /**
     * @Route("/remont-kofemashin-{brand}/", name="brand")
     */
    public function item($brand, BrandRepository $brand_repository, ServiceRepository $service_repository)
    {
        if ( ! $brand_entity = $brand_repository->findOneBy(['alias' => $brand])) {
            throw new NotFoundHttpException();
        }
        $breakdowns = $service_repository->findAllButExcluded([29, 30], false);
        $services   = $service_repository->findAllButExcluded([29, 30], true);
        
        return $this->render('brand/index.html.twig', [
            'brand'      => $brand_entity,
            'breakdowns' => $breakdowns,
            'services'   => $services,
        ]);
    }
    
    /**
     * @Route("/remont-kofemashin-{brand}/{model_or_service}/", name="model_or_service")
     */
    public function modelOrService(
        $brand,
        $model_or_service,
        BrandRepository $brand_repository,
        ModelRepository $model_repository,
        ServiceRepository $service_repository,
        MarkerReplaceService $marker_replace_service
    ) {
        if ( ! $brand_entity = $brand_repository->findOneBy(['alias' => $brand])) {
            throw new NotFoundHttpException();
        }
        $breakdowns = $service_repository->findAllButExcluded([29, 30], false);
        $services   = $service_repository->findAllButExcluded([29, 30], true);
        
        if ($model_entity = $model_repository->findOneBy(['alias' => $model_or_service])) {
            return $this->render('brand/model.html.twig', [
                'brand'      => $brand_entity,
                'model'      => $model_entity,
                'breakdowns' => $breakdowns,
                'services'   => $services,
            ]);
        } elseif ($service_entity = $service_repository->findOneBy(['alias' => $model_or_service])) {
            return $this->render('brand/service.html.twig', [
                'brand'      => $brand_entity,
                'service'    => $marker_replace_service->replaceMarkerBrandInOneService($service_entity, $brand_entity->getName()),
                'breakdowns' => $breakdowns,
                'services'   => $services,
            ]);
        } else {
            throw new NotFoundHttpException();
        }
        
    }
    
    
    
    /**
     * @Route("/remont-kofemashin-{brand}/{model}/{service}/", name="service")
     */
    /*public function service($service)
    {
        dd($service);
        return $this->render('brand/index.html.twig', [
            'controller_name' => 'BrandController',
        ]);
    }*/
}
