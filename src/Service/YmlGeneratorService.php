<?php

namespace App\Service;

use App\DTO\YmlDTO;
use App\Entity\Brand;
use App\Repository\BrandRepository;
use App\Repository\ServiceRepository;
use App\Repository\TypeRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class YmlGeneratorService
{
    /**
     * @var BrandRepository
     */
    protected $brand_repository;
    /**
     * @var ServiceRepository
     */
    protected $service_repository;
    /**
     * @var TypeRepository
     */
    protected $type_repository;
    /**
     * @var UrlGeneratorInterface
     */
    protected $router;
    private $id = 0;
    private $offers = [];
    private const IMAGE = 'https://remont-kofemashin.com/img/type_images/avtomat.jpg';
    private const BASE_URL = 'https://remont-kofemashin.com';
    private $services;
    
    public function __construct(
        BrandRepository $brand_repository,
        ServiceRepository $service_repository,
        TypeRepository $type_repository,
        UrlGeneratorInterface $router
    ) {
        $this->brand_repository   = $brand_repository;
        $this->service_repository = $service_repository;
        $this->type_repository    = $type_repository;
        
        $this->services = $this->service_repository->findAll();
        $this->router   = $router;
    }
    
    public function getOffers()
    {
        $this->main();
        $this->services();
        $this->brands();
        $this->types();
        
        return $this->offers;
    }
    
    private function getNextId()
    {
        return ++$this->id;
    }
    
    private function addOffer(YmlDTO $offer)
    {
        $offer->id                = $this->getNextId();
        $offer->price             = $offer->price ? : 450;
        $offer->picture           = $offer->picture ? : self::IMAGE;
        $offer->url               = self::BASE_URL . $offer->url;
        $this->offers[$offer->id] = $offer;
    }
    
    private function main()
    {
        $offer              = new YmlDTO();
        $offer->name        = 'Ремонт кофемашин - Сервисный центр «Ремонт Кофемашин»';
        $offer->description = 'Ремонт кофемашин 🔥 цена от 450₽. ✅ Бесплатный выезд на дом и диагностика кофемашины. ✅ Любой район Москвы и области. ✅ Гарантия на ремонт до 2 лет. ⭐ Сервисный центр «Ремонт Кофемашин» ☎ 8(495)015-60-98.';
        $offer->price       = 450;
        $offer->picture     = self::IMAGE;
        $offer->url         = '';
        $this->addOffer($offer);
    }
    
    private function services()
    {
        foreach ($this->services as $service) {
            $offer              = new YmlDTO();
            $seo_name           = str_replace(' #BRAND', '', $service->getSeoName());
            $offer->name        = $seo_name . ' по низкой цене';
            $offer->description = $seo_name . ' 🔥 цена ремонта от ' . $service->getPrice() . '₽. ✅ Бесплатный выезд на дом и диагностика кофемашины. ✅ Любой район Москвы и области. ✅ Гарантия на ремонт до 2 лет.  ⭐ Сервисный центр «Ремонт Кофемашин» ☎ 8(495)015-60-98.';
            $offer->price       = $service->getPrice();
            $offer->picture     = self::IMAGE;
            if ($service->getIsService()) {
                $offer->url = $this->router->generate('diagnostics_item', ['service' => $service->getAlias()]);
            } else {
                $offer->url = $this->router->generate('breakdown_item', ['breakdown' => $service->getAlias()]);
            }
            
            $this->addOffer($offer);
        }
    }
    
    private function brands()
    {
        $brands = $this->brand_repository->findAll();
        foreach ($brands as $brand) {
            $brand_image        = self::BASE_URL . '/img/brand_image/' . $brand->getImage();
            $offer              = new YmlDTO();
            $offer->name        = 'Ремонт кофемашин ' . $brand->getName() . ' по низкой цене';
            $offer->description = 'Ремонт кофемашин ' . $brand->getName() . ' 🔥 цена от 450₽. ✅ Бесплатный выезд на дом и диагностика кофемашины. ✅ Любой район Москвы и области. ✅ Гарантия на ремонт до 2 лет. ⭐ Сервисный центр «Ремонт Кофемашин» ☎ 8(495)015-60-98.';
            $offer->price       = 450;
            $offer->picture     = $brand_image;
            $offer->url         = $this->router->generate('brand', ['brand' => $brand->getAlias()]);;
            $this->addOffer($offer);
            
            $this->brand_models($brand, $brand_image);
            $this->brand_services($brand, $brand_image);
            
        }
    }
    
    private function brand_models(Brand $brand, $brand_image)
    {
        foreach ($brand->getModels() as $model) {
            $offer              = new YmlDTO();
            $offer->name        = 'Ремонт кофемашин ' . $brand->getName() . ' ' . $model->getName() . ' по низкой цене';
            $offer->description = 'Ремонт кофемашин ' . $brand->getName() . ' ' . $model->getName() . ' 🔥 цена от 450₽. ✅ Бесплатный выезд на дом и диагностика кофемашины. ✅ Любой район Москвы и области. ✅ Гарантия на ремонт до 2 лет. ⭐ Сервисный центр «Ремонт Кофемашин» ☎ 8(495)015-60-98.';
            $offer->price       = 450;
            $offer->picture     = $brand_image;
            $offer->url         = $this->router->generate('model_or_service',
                ['brand' => $brand->getAlias(), 'model_or_service' => $model->getAlias()]);
            $this->addOffer($offer);
        }
    }
    
    private function brand_services(Brand $brand, $brand_image)
    {
        foreach ($this->services as $service) {
            $offer              = new YmlDTO();
            $seo_name           = str_replace('#BRAND', $brand->getName(), $service->getSeoName());
            $offer->name        = $seo_name . ' по низкой цене';
            $offer->description = $seo_name . ' 🔥 цена ремонта от ' . $service->getPrice() . '₽. ✅ Бесплатный выезд на дом и диагностика кофемашины. ✅ Любой район Москвы и области. ✅ Гарантия на ремонт до 2 лет.  ⭐ Сервисный центр «Ремонт Кофемашин» ☎ 8(495)015-60-98.';
            $offer->price       = $service->getPrice();
            $offer->picture     = $brand_image;
            $offer->url         = $this->router->generate('model_or_service',
                ['brand' => $brand->getAlias(), 'model_or_service' => $service->getAlias()]);
            $this->addOffer($offer);
        }
    }
    
    private function types()
    {
        $types = $this->type_repository->findAll();
        foreach ($types as $type) {
            foreach ($this->services as $service) {
                $offer = new YmlDTO();
                $service->setSeoName(str_replace(' #BRAND', '', $service->getSeoName()));
                $offer->name        = $service->getSeoName() . ' - ' . $type->getMetaTitle() . ' по низкой цене';
                $offer->description = $service->getSeoName() . ' - ' . $type->getMetaTitle() . ' 🔥 цена ремонта от ' . $service->getPrice() . '₽. ✅ Бесплатный выезд на дом и диагностика кофемашины. ✅ Любой район Москвы и области. ✅ Гарантия на ремонт до 2 лет.  ⭐ Сервисный центр «Ремонт Кофемашин» ☎ 8(495)015-60-98.';
                $offer->price       = $service->getPrice();
                $offer->picture     = self::IMAGE;
                $offer->url         = $this->router->generate('type_service',
                    ['type' => $type->getAlias(), 'service' => $service->getAlias()]);
                $this->addOffer($offer);
            }
        }
    }
    
}