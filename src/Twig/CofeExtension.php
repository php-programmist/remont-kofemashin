<?php

namespace App\Twig;

use App\Repository\CofeRepository;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CofeExtension extends AbstractExtension
{
    /**
     * @var CofeRepository
     */
    protected $cofe_repository;
    
    public function __construct(CofeRepository $cofe_repository)
    {
        $this->cofe_repository = $cofe_repository;
    }
    
    public function getFunctions(): array
    {
        return [
            new TwigFunction('cofe_block', [$this, 'cofe_block'],['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function cofe_block(Environment $twig)
    {
        $items = $this->cofe_repository->findAll();
        return $twig->render('extension/cofe_block.html.twig', compact('items'));
    }
}
