<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeRepository")
 */
class Type
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Food", mappedBy="type")
     */
    private $foods;

    public function __construct()
    {
        $this->foods = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }
    //mes getter et setter generer en ligne de co avec mes relations
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Food[]
     */
    public function getFoods(): Collection
    {
        return $this->foods;
    }
    //Ma fonction qui me permet de recuperer food dans un array
    public function addFood(Food $food): self
    {
        if (!$this->foods->contains($food)) {
            $this->foods[] = $food;
            $food->setType($this);
        }

        return $this;
    }

    public function removeFood(Food $food): self
    {
        if ($this->foods->contains($food)) {
            $this->foods->removeElement($food);
            // set the owning side to null (unless already changed)
            if ($food->getType() === $this) {
                $food->setType(null);
            }
        }

        return $this;
    }




}
