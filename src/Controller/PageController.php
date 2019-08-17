<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(BrandRepository $brand_repository)
    {
        $brands = $brand_repository->findAll();
        return $this->render('page/index.html.twig', [
            'brands' => $brands,
        ]);
    }
}
