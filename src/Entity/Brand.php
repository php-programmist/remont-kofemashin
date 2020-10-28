<?php

namespace App\Entity;

use App\Entity\Contracts\PageInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BrandRepository")
 */
class Brand implements PageInterface
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
    private $name_ru;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Model", mappedBy="brand")
     */
    private $models;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    public function __construct()
    {
        $this->models = new ArrayCollection();
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

    public function getNameRu(): ?string
    {
        return $this->name_ru;
    }

    public function setNameRu(?string $name_ru): self
    {
        $this->name_ru = $name_ru;

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

    /**
     * @return Collection|Model[]
     */
    public function getModels(): Collection
    {
        return $this->models;
    }

    public function addModel(Model $model): self
    {
        if (!$this->models->contains($model)) {
            $this->models[] = $model;
            $model->setBrand($this);
        }

        return $this;
    }

    public function removeModel(Model $model): self
    {
        if ($this->models->contains($model)) {
            $this->models->removeElement($model);
            // set the owning side to null (unless already changed)
            if ($model->getBrand() === $this) {
                $model->setBrand(null);
            }
        }

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

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

    public function getPath(): string
    {
        return sprintf('/remont-kofemashin-%s/', $this->getAlias());
    }

    public function getH1(): string
    {
        return sprintf('Ремонт кофемашин %s в Москве', $this->getName());
    }

    public function getCardHeader(): string
    {
        return sprintf('Ремонт кофемашины %s', $this->getName());
    }

    public function getCardImage(): string
    {
        return sprintf('/img/brand_image/%s', $this->getImage());
    }

    public function getTextComputed(): string
    {
        if (null !== $this->getText()) {
            return $this->getText();
        }
        return sprintf('<p>«Ремонт Кофемашин» - сервис по ремонту и обслуживанию кофемашин %s в Москве. В нашей сервисной мастерской работают профессионалы своего дела с огромным опытом работы. Имеется все необходимое оборудование и инструменты. Запчасти и расходные материалы для ремонта кофемашины %s уже есть в наличии. Выезд мастера, диагностика и забор кофемашины в сервис бесплатный!</p>
                    
                        <p>&#9989; Бесплатная доставка до сервиса.</p>
                        <p>&#9989; Гарантия на ремонт кофемашин %s от 6 месяцев.</p>
                        <p>&#9989; Ремонтируем только то, что действительно сломалось!</p>
                    
                    <p class="price"><b>Ремонт кофемашины %s от 450₽</b></p>',
            $this->getName(), $this->getName(), $this->getName(), $this->getName());
    }
}
