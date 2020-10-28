<?php

namespace App\Entity;

use App\Entity\Contracts\TurboPageInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeRepository")
 */
class Type implements TurboPageInterface
{
    use Traits\RatingTrait;
    use Traits\ModifyDateTrait;
    const MIN_RATING_VALUE = 4.6;
    const MAX_RATING_VALUE = 4.9;
    const MIN_RATING_COUNT = 7;
    const MAX_RATING_COUNT = 22;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $alias;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $meta_title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $meta_description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $meta_key_words;


    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    public function __construct()
    {
        $this->setRandomRatingValue();
        $this->setRandomRatingCount();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getMetaTitle(): ?string
    {
        return $this->meta_title;
    }

    public function setMetaTitle(?string $meta_title): self
    {
        $this->meta_title = $meta_title;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->meta_description;
    }

    public function setMetaDescription(?string $meta_description): self
    {
        $this->meta_description = $meta_description;

        return $this;
    }

    public function getMetaKeyWords(): ?string
    {
        return $this->meta_key_words;
    }

    public function setMetaKeyWords(?string $meta_key_words): self
    {
        $this->meta_key_words = $meta_key_words;

        return $this;
    }
    
    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getPath():string
    {
        return sprintf('/type-%s/', $this->getAlias());
    }

    public function getH1():string
    {
        return $this->getMetaTitle();
    }

    public function getCardHeader():string
    {
        return $this->getMetaTitle();
    }

    public function getCardImage():string
    {
        return sprintf('/img/type_images/%s', $this->getImage());
    }

    public function getTextComputed():string
    {
        return sprintf('<p>«Ремонт Кофемашин» - сервис по ремонту и обслуживает %s в Москве. В нашей сервисной мастерской работают профессионалы своего дела с огромным опытом работы. Имеется все необходимое оборудование и инструменты. Запчасти и расходные материалы для ремонта %s уже есть в наличии. Выезд мастера, диагностика и забор кофемашины в сервис бесплатный!</p>
                    
                        <p>&#9989; Бесплатная доставка до сервиса.</p>
                        <p>&#9989; Гарантия на %s от 6 месяцев.</p>
                        <p>&#9989; Ремонтируем только то, что действительно сломалось!</p>
                   
                    <p class="price"><b>%s от 450₽</b></p>',
            $this->getName(), $this->getName(),$this->getMetaTitle(), $this->getMetaTitle());
    }
}
