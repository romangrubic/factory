<?php

namespace App\Entity;

use App\Repository\IngredientsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IngredientsRepository::class)
 */
class Ingredients
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
     * @ORM\OneToMany(targetEntity=IngredientsTranslations::class, mappedBy="ingredients")
     */
    private $ingredientsTranslations;

    /**
     * @ORM\ManyToMany(targetEntity=Meals::class, mappedBy="ingredients")
     */
    private $meals;

    public function __construct()
    {
        $this->ingredientsTranslations = new ArrayCollection();
        $this->meals = new ArrayCollection();
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
     * @return Collection<int, IngredientsTranslations>
     */
    public function getIngredientsTranslations(): Collection
    {
        return $this->ingredientsTranslations;
    }

    public function addIngredientsTranslation(IngredientsTranslations $ingredientsTranslation): self
    {
        if (!$this->ingredientsTranslations->contains($ingredientsTranslation)) {
            $this->ingredientsTranslations[] = $ingredientsTranslation;
            $ingredientsTranslation->setIngredients($this);
        }

        return $this;
    }

    public function removeIngredientsTranslation(IngredientsTranslations $ingredientsTranslation): self
    {
        if ($this->ingredientsTranslations->removeElement($ingredientsTranslation)) {
            // set the owning side to null (unless already changed)
            if ($ingredientsTranslation->getIngredients() === $this) {
                $ingredientsTranslation->setIngredients(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Meals>
     */
    public function getMeals(): Collection
    {
        return $this->meals;
    }

    public function addMeal(Meals $meal): self
    {
        if (!$this->meals->contains($meal)) {
            $this->meals[] = $meal;
            $meal->addIngredient($this);
        }

        return $this;
    }

    public function removeMeal(Meals $meal): self
    {
        if ($this->meals->removeElement($meal)) {
            $meal->removeIngredient($this);
        }

        return $this;
    }
}
