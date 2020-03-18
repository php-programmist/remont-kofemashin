<?php

namespace App\Controller;

use App\Entity\Cofe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CofeController extends AbstractController
{
    /**
     * @Route("/cofe/{slug}/", name="cofe")
     */
    public function index(Cofe $cofe)
    {
        return $this->render('cofe/index.html.twig', [
            'item' => $cofe,
        ]);
    }
}
