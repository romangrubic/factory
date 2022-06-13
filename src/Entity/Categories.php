<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriesRepository::class)
 */
class Categories
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=CategoriesTranslations::class, mappedBy="categories_id")
     */
    private $categoriesTranslations;

    public function __construct()
    {
        $this->categoriesTranslations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, CategoriesTranslations>
     */
    public function getCategoriesTranslations(): Collection
    {
        return $this->categoriesTranslations;
    }

    public function addCategoriesTranslation(CategoriesTranslations $categoriesTranslation): self
    {
        if (!$this->categoriesTranslations->contains($categoriesTranslation)) {
            $this->categoriesTranslations[] = $categoriesTranslation;
            $categoriesTranslation->setCategoriesId($this);
        }

        return $this;
    }

    public function removeCategoriesTranslation(CategoriesTranslations $categoriesTranslation): self
    {
        if ($this->categoriesTranslations->removeElement($categoriesTranslation)) {
            // set the owning side to null (unless already changed)
            if ($categoriesTranslation->getCategoriesId() === $this) {
                $categoriesTranslation->setCategoriesId(null);
            }
        }

        return $this;
    }
}
