<?php

namespace App\Entity;

use App\Entity\Like;
use App\Entity\User;
use App\Entity\Category;

use App\Repository\TravauxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TravauxRepository::class)
 */
class Travaux
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
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $travail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lien_1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lien_2;
    
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Travaux")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Date;

    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     */
    private $Categorie;

    /**
     * @ORM\OneToMany(targetEntity=Like::class, mappedBy="Travaux")
     */
    private $likes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $score;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
   
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTravail(): ?string
    {
        return $this->travail;
    }

    public function setTravail(string $travail): self
    {
        $this->travail = $travail;

        return $this;
    }

    public function getLien1(): ?string
    {
        return $this->lien_1;
    }

    public function setLien1(string $lien_1): self
    {
        $this->lien_1 = $lien_1;

        return $this;
    }

    public function getLien2(): ?string
    {
        return $this->lien_2;
    }

    public function setLien2(?string $lien_2): self
    {
        $this->lien_2 = $lien_2;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->Date;
    }

    public function setDate(string $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->Categorie;
    }

    public function setCategorie(string $Categorie): self
    {
        $this->Categorie = $Categorie;

        return $this;
    }

    /**
     * @return Collection|Like[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setTravaux($this);
        }

        return $this;
    }

    public function removeLike(Like $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getTravaux() === $this) {
                $like->setTravaux(null);
            }
        }

        return $this;
    }

    /** 
     * Vérification si le travail est like par l'utilisateur
     * 
     * @param \App\Entity\User $user
     * @return boolean
    */

    public function isLikedByUser(User $user) : bool {

        foreach($this->likes as $like) {
            if ($like->getUser() === $user) return true;
        }

        return false;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): self
    {
        $this->score = $score;

        return $this;
    }

}
