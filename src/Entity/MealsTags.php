<?php

namespace App\Entity;

use App\Repository\MealsTagsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MealsTagsRepository::class)
 */
class MealsTags
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Meals::class, inversedBy="mealsTags")
     * @ORM\JoinColumn(nullable=false)
     */
    private $meals;

    /**
     * @ORM\ManyToOne(targetEntity=Tags::class, inversedBy="mealsTags")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tags;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeals(): ?Meals
    {
        return $this->meals;
    }

    public function setMeals(?Meals $meals): self
    {
        $this->meals = $meals;

        return $this;
    }

    public function getTags(): ?Tags
    {
        return $this->tags;
    }

    public function setTags(?Tags $tags): self
    {
        $this->tags = $tags;

        return $this;
    }
}
