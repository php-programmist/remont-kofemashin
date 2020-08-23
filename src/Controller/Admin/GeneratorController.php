<?php

namespace App\Controller\Admin;

use App\Repository\BrandRepository;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GeneratorController extends AbstractController
{
    /**
     * @Route("/admin/generator/rating/", name="admin_generator_rating")
     */
    public function rating(BrandRepository $brandRepository, TypeRepository $typeRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $brands = $brandRepository->findAll();
        foreach ($brands as $page) {
            $page->setRatingValue($page->getRandomRatingValue());
            $page->setRatingCount($page->getRandomRatingCount());
        }
        $types = $typeRepository->findAll();
        foreach ($types as $type) {
            $type->setRatingValue($type->getRandomRatingValue());
            $type->setRatingCount($type->getRandomRatingCount());
        }
        $em->flush();
        
        dd('Рейтинги перегенерированы для страниц: '.count($brands));
    }
}
