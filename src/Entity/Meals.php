<?php

namespace App\Entity;

use App\Repository\MealsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MealsRepository::class)
 */
class Meals
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="meals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=MealsTranslations::class, mappedBy="meals")
     */
    private $mealsTranslations;

    public function __construct()
    {
        $this->mealsTranslations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryId(): ?Categories
    {
        return $this->category_id;
    }

    public function setCategoryId(?Categories $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, MealsTranslations>
     */
    public function getMealsTranslations(): Collection
    {
        return $this->mealsTranslations;
    }

    public function addMealsTranslation(MealsTranslations $mealsTranslation): self
    {
        if (!$this->mealsTranslations->contains($mealsTranslation)) {
            $this->mealsTranslations[] = $mealsTranslation;
            $mealsTranslation->setMeals($this);
        }

        return $this;
    }

    public function removeMealsTranslation(MealsTranslations $mealsTranslation): self
    {
        if ($this->mealsTranslations->removeElement($mealsTranslation)) {
            // set the owning side to null (unless already changed)
            if ($mealsTranslation->getMeals() === $this) {
                $mealsTranslation->setMeals(null);
            }
        }

        return $this;
    }
}
