<?php

namespace App\Controller;

use App\Adapter\RssPageAdapter;
use App\Repository\BrandRepository;
use App\Repository\TypeRepository;
use PhpProgrammist\YandexTurboRssGeneratorBundle\Adapters\BasePage;
use PhpProgrammist\YandexTurboRssGeneratorBundle\YandexTurboRssGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TurboPageController extends AbstractController
{

    /**
     * @Route("/turbo.xml", name="turbo_pages")
     * @param RssPageAdapter $adapter
     * @param BrandRepository $brandRepository
     * @param TypeRepository $typeRepository
     * @param YandexTurboRssGenerator $generator
     * @return Response
     */
    public function index(
        RssPageAdapter $adapter,
        BrandRepository $brandRepository,
        TypeRepository $typeRepository,
        YandexTurboRssGenerator $generator
    ) {

        $base_page = new BasePage(
            'Ремонт кофемашин цена в Москве',
            'Ремонт кофемашин цена от 450₽.  Бесплатный выезд на дом и диагностика кофемашины. Любой район Москвы и области.  Гарантия на ремонт до 2 лет.  Сервисный центр «Ремонт Кофемашин». тел:  8(495)015-60-98.',
            '/'
        );

        $adapter
            ->setBasePage($base_page)
            ->setOriginalItems(array_merge(
                $typeRepository->findAll(),
                $brandRepository->findAll()
            ));

        return $generator->render($adapter, $base_page);
    }

}
