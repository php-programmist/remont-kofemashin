<?php

namespace App\Service;

use App\Entity\Service;

class MarkerReplaceService
{
    /**
     * @param Service[] $services
     * @param string    $brand_name
     *
     * @return Service[]
     */
    public function replaceMarkerBrandInAllServices($services, $brand_name)
    {
        foreach ($services as $index => $service) {
            $services[$index] = $this->replaceMarkerBrandInOneService($service,$brand_name);
        }
        
        return $services;
    }
    
    /**
     * @param Service $service
     * @param string  $brand_name
     *
     * @return Service
     */
    public function replaceMarkerBrandInOneService($service, $brand_name)
    {
        $service->setSeoName(str_replace('#BRAND', $brand_name, $service->getSeoName()));
        $service->setText(str_replace('#BRAND', $brand_name, $service->getText()));
        return $service;
    }
}