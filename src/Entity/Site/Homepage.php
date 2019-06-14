<?php

namespace App\Entity\Site;

use App\Entity\Objet\Illustration;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Site\HomepageRepository")
 */
class Homepage {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=50)
	 */
	private $libelle;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $titre;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $resume;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $description;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Objet\Illustration")
	 */
	private $images;

	public function __construct() {
		$this->images = new ArrayCollection();
	}

	public function getId():  ? int {
		return $this->id;
	}

	public function getLibelle() :  ? string {
		return $this->libelle;
	}

	public function setLibelle(string $libelle) : self{
		$this->libelle = $libelle;

		return $this;
	}

	public function getTitre():  ? string {
		return $this->titre;
	}

	public function setTitre(string $titre) : self{
		$this->titre = $titre;

		return $this;
	}

	public function getResume():  ? string {
		return $this->resume;
	}

	public function setResume( ? string $resume) : self{
		$this->resume = $resume;

		return $this;
	}

	public function getDescription() :  ? string {
		return $this->description;
	}

	public function setDescription( ? string $description) : self{
		$this->description = $description;

		return $this;
	}

	/**
	 * @return Collection|Illustration[]
	 */
	public function getImages() : Collection {
		return $this->images;
	}

	public function addImage(Illustration $image): self {
		if (!$this->images->contains($image)) {
			$this->images[] = $image;
		}

		return $this;
	}

	public function removeImage(Illustration $image): self {
		if ($this->images->contains($image)) {
			$this->images->removeElement($image);
		}

		return $this;
	}
}
