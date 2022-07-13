<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $nomProjet;

    /**
     * @ORM\Column(type="date")
     */
    private ?\DateTimeInterface $dateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private ?\DateTimeInterface $dateFin;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $descripProjet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $documentation;

    private string $doc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $vignetteProjet;

    private string $vig;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $lienProjet;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $technologie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $cahierDesCharges;

    private string $cdc;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $veille;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $participant;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $outil;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $missionRealise;

    /**
     * @ORM\OneToMany(targetEntity=ImageProject::class, mappedBy="projet")
     */
    private $imgProjet;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $contexte;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $encadrant;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $archiveProjet;


    public function __construct()
    {
        $this->imgProject = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProjet(): ?string
    {
        return $this->nomProjet;
    }

    public function setNomProjet(string $nomProjet): self
    {
        $this->nomProjet = $nomProjet;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getDescripProjet(): ?string
    {
        return $this->descripProjet;
    }

    public function setDescripProjet(string $descripProjet): self
    {
        $this->descripProjet = $descripProjet;

        return $this;
    }

    public function getDocumentation(): ?string
    {
        return $this->documentation;
    }

    public function setDocumentation(?string $documentation): self
    {
        $this->documentation = $documentation;

        return $this;
    }

    public function getVignetteProjet(): ?string
    {
        return $this->vignetteProjet;
    }

    public function setVignetteProjet(string $vignetteProjet): self
    {
        $this->vignetteProjet = $vignetteProjet;

        return $this;
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

    public function getTechnologie(): ?string
    {
        return $this->technologie;
    }

    public function setTechnologie(string $technologie): self
    {
        $this->technologie = $technologie;

        return $this;
    }

    public function getCahierDesCharges(): ?string
    {
        return $this->cahierDesCharges;
    }

    public function setCahierDesCharges(?string $cahierDesCharges): self
    {
        $this->cahierDesCharges = $cahierDesCharges;

        return $this;
    }

    public function getVeille(): ?string
    {
        return $this->veille;
    }

    public function setVeille(string $veille): self
    {
        $this->veille = $veille;

        return $this;
    }

    public function getParticipant(): ?string
    {
        return $this->participant;
    }

    public function setParticipant(string $participant): self
    {
        $this->participant = $participant;

        return $this;
    }

    public function getOutil(): ?string
    {
        return $this->outil;
    }

    public function setOutil(?string $outil): self
    {
        $this->outil = $outil;

        return $this;
    }

    public function getMissionRealise(): ?string
    {
        return $this->missionRealise;
    }

    public function setMissionRealise(?string $missionRealise): self
    {
        $this->missionRealise = $missionRealise;

        return $this;
    }

    /**
     * @return Collection|ImageProjet[]
     */
    public function getImgProjet(): Collection|array
    {
        return $this->imgProjet;
    }

    public function addImgProjet(ImageProject $imgProjet): self
    {
        if (!$this->imgProjet->contains($imgProjet)) {
            $this->imgProjet[] = $imgProjet;
            $imgProjet->setProjet($this);
        }

        return $this;
    }

    public function removeImgProjet(ImageProject $imgProjet): self
    {
        if ($this->imgProjet->removeElement($imgProjet)) {
            // set the owning side to null (unless already changed)
            if ($imgProjet->getProjet() === $this) {
                $imgProjet->setProjet(null);
            }
        }

        return $this;
    }


    public function getContexte(): ?string
    {
        return $this->contexte;
    }

    public function setContexte(string $contexte): self
    {
        $this->contexte = $contexte;

        return $this;
    }

    public function getEncadrant(): ?string
    {
        return $this->encadrant;
    }

    public function setEncadrant(string $encadrant): self
    {
        $this->encadrant = $encadrant;

        return $this;
    }

    public function getArchiveProjet(): ?bool
    {
        return $this->archiveProjet;
    }

    public function setArchiveProjet(bool $archiveProjet): self
    {
        $this->archiveProjet = $archiveProjet;

        return $this;
    }
}
