<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Restaurant
 *
 * @ORM\Table(name="restaurant")
 * @ORM\Entity(repositoryClass="App\Repository\RestaurantRepository")
 */
class Restaurant
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max = 30,
     *      minMessage = " Minimum {{ limit }} caracteres",
     *      maxMessage = " Maximum {{ limit }} caracteres"
     * )
     * @Assert\NotBlank(message="champ obligatoire")
     * @ORM\Column(name="nom", type="string", length=256, nullable=false)
     */
    private $nom;

    /**
     * @var string
     * @Assert\NotBlank(message="champ obligatoire")
     *@Assert\Length(
     *      min = 2,
     *      max = 30,
     *      minMessage = " Minimum {{ limit }} caracteres",
     *      maxMessage = " Maximum {{ limit }} caracteres"
     * )
     * @ORM\Column(name="position", type="string", length=256, nullable=false)
     */
    private $position;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_entrer", type="date", nullable=false)
     */
    private $dateEntrer;

    /**
     * @var string
     * @ORM\Column(name="image", type="blob", length=0)
     */
    private $image;

    /**
     * @var string
     *@Assert\Length(
     *      min = 2,
     *      max = 30,
     *      minMessage = " Minimum {{ limit }} caracteres",
     *      maxMessage = " Maximum {{ limit }} caracteres"
     * )
     * @ORM\Column(name="gerant_restaurant", type="string", length=256)
     */
    private $gerantRestaurant;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $likeRestaurant;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dislikeRestaurant;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $idClient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getDateEntrer(): ?\DateTimeInterface
    {
        return $this->dateEntrer;
    }

    public function setDateEntrer(\DateTimeInterface $dateEntrer): self
    {
        $this->dateEntrer = $dateEntrer;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getGerantRestaurant(): ?string
    {
        return $this->gerantRestaurant;
    }

    public function setGerantRestaurant(string $gerantRestaurant): self
    {
        $this->gerantRestaurant = $gerantRestaurant;

        return $this;
    }

    public function getLikeRestaurant(): ?int
    {
        return $this->likeRestaurant;
    }

    public function setLikeRestaurant(?int $likeRestaurant): self
    {
        $this->likeRestaurant = $likeRestaurant;

        return $this;
    }

    public function getDislikeRestaurant(): ?int
    {
        return $this->dislikeRestaurant;
    }

    public function setDislikeRestaurant(?int $dislikeRestaurant): self
    {
        $this->dislikeRestaurant = $dislikeRestaurant;

        return $this;
    }

    public function getIdClient(): ?int
    {
        return $this->idClient;
    }

    public function setIdClient(?int $idClient): self
    {
        $this->idClient = $idClient;

        return $this;
    }

}
