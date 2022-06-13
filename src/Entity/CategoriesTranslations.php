<?php

namespace App\Entity;

use App\Repository\CategoriesTranslationsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriesTranslationsRepository::class)
 */
class CategoriesTranslations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="categoriesTranslations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categories_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $locale;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoriesId(): ?Categories
    {
        return $this->categories_id;
    }

    public function setCategoriesId(?Categories $categories_id): self
    {
        $this->categories_id = $categories_id;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
