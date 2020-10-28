<?php

namespace App\Adapter;

use App\Entity\Brand;
use App\Entity\Contracts\TurboPageInterface;
use App\Repository\ServiceRepository;
use PhpProgrammist\YandexTurboRssGeneratorBundle\Adapters\BasePageInterface;
use PhpProgrammist\YandexTurboRssGeneratorBundle\Adapters\RssAdapterInterface;
use PhpProgrammist\YandexTurboRssGeneratorBundle\RssItem;
use Twig\Environment;

class RssPageAdapter implements RssAdapterInterface
{
    /**
     * @var RssItem[]
     */
    private $items;
    /**
     * @var BasePageInterface
     */
    private $basePage;
    /**
     * @var Environment
     */
    private $twig;
    private $originalItems;
    /**
     * @var ServiceRepository
     */
    private $serviceRepository;

    /**
     * @param Environment $twig
     * @param ServiceRepository $serviceRepository
     */
    public function __construct(
        Environment $twig,
        ServiceRepository $serviceRepository
    ) {
        $this->twig = $twig;
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * @return RssItem[]
     */
    public function getItems(): array
    {
        if (empty($this->items)) {
            $this->adapt();
        }
        return $this->items;
    }

    protected function adapt(): void
    {
        /** @var TurboPageInterface $originalItem */
        foreach ($this->originalItems as $originalItem) {
            $link = $originalItem->getPath();
            $item = new RssItem(
                $originalItem->getId(),
                $link,
                strip_tags($originalItem->getH1()),
                $originalItem->getModifyDate()->getTimestamp(),
                $this->getText($originalItem)
            );
            $item->setAllBreadcrumbs('Главная', $this->basePage);
            $this->addItem($item);
        }
    }

    private function getText(TurboPageInterface $page): string
    {
        $breakdowns = $this->serviceRepository->findAllButExcluded([29, 30], false);
        $services   = $this->serviceRepository->findAllButExcluded([29, 30], true);
        return $this->twig->render('turbo/content.html.twig', [
            'page' => $page,
            'breakdowns' => $breakdowns,
            'services'   => $services,
        ]);
    }

    protected function addItem(RssItem $item): void
    {
        $this->items[] = $item;
    }

    /**
     * @param Brand[]|array
     * @return $this
     */
    public function setOriginalItems(array $originalItems): self
    {
        $this->originalItems = $originalItems;
        return $this;
    }

    /**
     * @param BasePageInterface $basePage
     * @return $this
     */
    public function setBasePage(BasePageInterface $basePage): self
    {
        $this->basePage = $basePage;
        return $this;
    }
}