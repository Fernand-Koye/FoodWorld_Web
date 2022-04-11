<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity
 */
class Client
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
     *
     * @ORM\Column(name="nom", type="string", length=256, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prÃ©nom", type="string", length=256, nullable=false)
     */
    private $prã©nom;

    /**
     * @var string
     *
     * @ORM\Column(name="pwd", type="string", length=256, nullable=false)
     */
    private $pwd;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=50, nullable=false)
     */
    private $mail;

    /**
     * @var int
     *
     * @ORM\Column(name="type_user", type="integer", nullable=false)
     */
    private $typeUser;

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

    public function getPrã©nom(): ?string
    {
        return $this->prã©nom;
    }

    public function setPrã©nom(string $prã©nom): self
    {
        $this->prã©nom = $prã©nom;

        return $this;
    }

    public function getPwd(): ?string
    {
        return $this->pwd;
    }

    public function setPwd(string $pwd): self
    {
        $this->pwd = $pwd;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getTypeUser(): ?int
    {
        return $this->typeUser;
    }

    public function setTypeUser(int $typeUser): self
    {
        $this->typeUser = $typeUser;

        return $this;
    }


}
