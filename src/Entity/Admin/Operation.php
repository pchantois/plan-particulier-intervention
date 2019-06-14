<?php

namespace App\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\OperationRepository")
 */
class Operation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $montant;

    /**
     * @ORM\Column(type="date")
     */
    private $annee;

    /**
     * @ORM\Column(type="boolean")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin\RegroupementOpe", inversedBy="operations")
     */
    private $regroupementOpe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin\Quartier", inversedBy="operations")
     */
    private $quartier;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin\CodeMaire", inversedBy="operations")
     */
    private $codeMaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin\NatureOpe", inversedBy="operations")
     */
    private $natureOpe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin\PolitiquePub", inversedBy="operations")
     */
    private $politiquePub;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(?int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getAnnee(): ?\DateTimeInterface
    {
        return $this->annee;
    }

    public function setAnnee(?\DateTimeInterface $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getType(): ?bool
    {
        return $this->type;
    }

    public function setType(?bool $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getRegroupementOpe(): ?RegroupementOpe
    {
        return $this->regroupementOpe;
    }

    public function setRegroupementOpe(?RegroupementOpe $regroupementOpe): self
    {
        $this->regroupementOpe = $regroupementOpe;

        return $this;
    }

    public function getRelation(): ?Quartier
    {
        return $this->relation;
    }

    public function setRelation(?Quartier $relation): self
    {
        $this->relation = $relation;

        return $this;
    }

    public function getCodeMaire(): ?CodeMaire
    {
        return $this->codeMaire;
    }

    public function setCodeMaire(?CodeMaire $codeMaire): self
    {
        $this->codeMaire = $codeMaire;

        return $this;
    }

    public function getNatureOpe(): ?NatureOpe
    {
        return $this->NatureOpe;
    }

    public function setNatureOpe(?NatureOpe $NatureOpe): self
    {
        $this->NatureOpe = $NatureOpe;

        return $this;
    }

    public function getPolitiquePub(): ?PolitiquePub
    {
        return $this->PolitiquePub;
    }

    public function setPolitiquePub(?PolitiquePub $PolitiquePub): self
    {
        $this->PolitiquePub = $PolitiquePub;

        return $this;
    }
}
