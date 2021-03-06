<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegionRepository")
 */
class Region
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Appellation", mappedBy="region")
     */
    private $appellations;

    public function __construct()
    {
        $this->appellations = new ArrayCollection();
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

    /**
     * @return Collection|Appellation[]
     */
    public function getAppellations(): Collection
    {
        return $this->appellations;
    }

    public function addAppellation(Appellation $appellation): self
    {
        if (!$this->appellations->contains($appellation)) {
            $this->appellations[] = $appellation;
            $appellation->setRegion($this);
        }

        return $this;
    }

    public function removeAppellation(Appellation $appellation): self
    {
        if ($this->appellations->contains($appellation)) {
            $this->appellations->removeElement($appellation);
            // set the owning side to null (unless already changed)
            if ($appellation->getRegion() === $this) {
                $appellation->setRegion(null);
            }
        }

        return $this;
    }
}
