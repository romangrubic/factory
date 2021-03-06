<?php

namespace App\Entity;

use App\Repository\MealsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass=MealsRepository::class)
 * @Gedmo\SoftDeleteable(fieldName="deleted_at", timeAware=false, hardDelete=false)
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
     * @ORM\OneToMany(targetEntity="MealsTranslations", mappedBy="meals", fetch="EAGER")
     * @ORM\JoinColumn(name="meals", referencedColumnName="id")
     */
    private $mealsTranslations;

    /**
     * @ORM\ManyToMany(targetEntity=Tags::class, inversedBy="meals")
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity=Ingredients::class, inversedBy="meals")
     */
    private $ingredients;

    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deleted_at;

    /**
     * @ORM\OneToMany(targetEntity=MealsTags::class, mappedBy="meals")
     */
    private $mealsTags;

    public function __construct()
    {
        $this->mealsTranslations = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
        $this->mealsTags = new ArrayCollection();
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

    /**
     * @return Collection<int, Tags>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tags $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tags $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection<int, Ingredients>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredients $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
        }

        return $this;
    }

    public function removeIngredient(Ingredients $ingredient): self
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeInterface $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    /**
     * @return Collection<int, MealsTags>
     */
    public function getMealsTags(): Collection
    {
        return $this->mealsTags;
    }

    public function addMealsTag(MealsTags $mealsTag): self
    {
        if (!$this->mealsTags->contains($mealsTag)) {
            $this->mealsTags[] = $mealsTag;
            $mealsTag->setMeals($this);
        }

        return $this;
    }

    public function removeMealsTag(MealsTags $mealsTag): self
    {
        if ($this->mealsTags->removeElement($mealsTag)) {
            // set the owning side to null (unless already changed)
            if ($mealsTag->getMeals() === $this) {
                $mealsTag->setMeals(null);
            }
        }

        return $this;
    }
}
