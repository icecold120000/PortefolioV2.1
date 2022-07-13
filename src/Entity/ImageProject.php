<?php

namespace App\Entity;

use App\Repository\ImageProjectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageProjectRepository::class)
 */
class ImageProject
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
    private ?string $lienProjet;

    private string $image;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="imgProjet")
     */
    private $projet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLienProjet(): ?string
    {
        return $this->lienProjet;
    }

    public function setLienProjet(string $lienProjet): self
    {
        $this->lienProjet = $lienProjet;

        return $this;
    }

    public function getProjet(): ?Project
    {
        return $this->projet;
    }

    public function setProjet(?Project $projet): self
    {
        $this->projet = $projet;

        return $this;
    }
}
