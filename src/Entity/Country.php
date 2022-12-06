<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
{
    /**
      * @ORM\Id
      * @ORM\GeneratedValue(strategy="AUTO")
      * @ORM\Column(type="integer")
      */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=City::class, mappedBy="type")
     */
    private $Cities;

    public function __construct()
    {
        $this->Cities = new ArrayCollection();
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
     * @return Collection|City[]
     */
    public function getCities(): Collection
    {
        return $this->Cities;
    }

    public function addCity(City $City): self
    {
        if (!$this->Cities->contains($City)) {
            $this->Cities[] = $City;
            $City->setCountry($this);
        }

        return $this;
    }

    public function removeCountry(City $City): self
    {
        if ($this->Cities->removeElement($City)) {
            // set the owning side to null (unless already changed)
            if ($City->getCountry() === $this) {
                $City->setCountry(null);
            }
        }

        return $this;
    }

    public function __toString(){
        // to show the name of the Category in the select
        return $this->name;
    }
}