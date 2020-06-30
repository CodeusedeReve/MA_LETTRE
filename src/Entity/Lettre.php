<?php

namespace App\Entity;

use App\Repository\LettreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=LettreRepository::class)
 */
class Lettre
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
    private $nom;

    /**
     * @ORM\Column(type="integer")
     * *@Assert\Length(min=1,max=2)
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $textlettre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url()
     */
    private $imagelettre;

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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTextlettre(): ?string
    {
        return $this->textlettre;
    }

    public function setTextlettre(?string $textlettre): self
    {
        $this->textlettre = $textlettre;

        return $this;
    }

    public function getImagelettre(): ?string
    {
        return $this->imagelettre;
    }

    public function setImagelettre(?string $imagelettre): self
    {
        $this->imagelettre = $imagelettre;

        return $this;
    }
}
