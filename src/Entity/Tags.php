<?php

namespace App\Entity;

use App\Repository\TagsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagsRepository::class)
 */
class Tags
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=TagsTranslations::class, mappedBy="tags_id", fetch="EAGER")
     * @ORM\JoinColumn(name="tags_id", referencedColumnName="id")
     */
    private $tagsTranslations;

    /**
     * @ORM\ManyToMany(targetEntity=Meals::class, mappedBy="tags")
     */
    private $meals;

    /**
     * @ORM\OneToMany(targetEntity=MealsTags::class, mappedBy="tags")
     */
    private $mealsTags;

    public function __construct()
    {
        $this->tagsTranslations = new ArrayCollection();
        $this->meals = new ArrayCollection();
        $this->mealsTags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, TagsTranslations>
     */
    public function getTagsTranslations(): Collection
    {
        return $this->tagsTranslations;
    }

    public function addTagsTranslation(TagsTranslations $tagsTranslation): self
    {
        if (!$this->tagsTranslations->contains($tagsTranslation)) {
            $this->tagsTranslations[] = $tagsTranslation;
            $tagsTranslation->setTagsId($this);
        }

        return $this;
    }

    public function removeTagsTranslation(TagsTranslations $tagsTranslation): self
    {
        if ($this->tagsTranslations->removeElement($tagsTranslation)) {
            // set the owning side to null (unless already changed)
            if ($tagsTranslation->getTagsId() === $this) {
                $tagsTranslation->setTagsId(null);
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
            $meal->addTag($this);
        }

        return $this;
    }

    public function removeMeal(Meals $meal): self
    {
        if ($this->meals->removeElement($meal)) {
            $meal->removeTag($this);
        }

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
            $mealsTag->setTags($this);
        }

        return $this;
    }

    public function removeMealsTag(MealsTags $mealsTag): self
    {
        if ($this->mealsTags->removeElement($mealsTag)) {
            // set the owning side to null (unless already changed)
            if ($mealsTag->getTags() === $this) {
                $mealsTag->setTags(null);
            }
        }

        return $this;
    }
}
