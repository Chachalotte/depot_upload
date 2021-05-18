<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    
    public function __toString(){
        // Or change the property that you want to show in the select.
        return $this->category_name;
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $category_name;

    /**
     * @ORM\OneToMany(targetEntity=travaux::class, mappedBy="category")
     */
    private $Travaux;

    public function __construct()
    {
        $this->Travaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->category_name;
    }

    public function setCategoryName(string $category_name): self
    {
        $this->category_name = $category_name;

        return $this;
    }

    /**
     * @return Collection|travaux[]
     */
    public function getTravaux(): Collection
    {
        return $this->Travaux;
    }

    public function addTravaux(travaux $travaux): self
    {
        if (!$this->Travaux->contains($travaux)) {
            $this->Travaux[] = $travaux;
            $travaux->setCategory($this);
        }

        return $this;
    }

    public function removeTravaux(travaux $travaux): self
    {
        if ($this->Travaux->removeElement($travaux)) {
            // set the owning side to null (unless already changed)
            if ($travaux->getCategory() === $this) {
                $travaux->setCategory(null);
            }
        }

        return $this;
    }

}
