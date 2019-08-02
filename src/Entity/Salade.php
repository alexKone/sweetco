<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\Api\CreateSalade;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SaladeRepository")
 */
class Salade {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 * @Groups({"salade:read", "salade:post"})
	 */
	private $id;

	/**
	 * @Groups({"billing:read", "salade:read",  "salade:post"})
	 * @ORM\ManyToOne(targetEntity="App\Entity\Base", inversedBy="salades", cascade={"persist"})
	 */
	private $base;

	/**
	 * @Groups({"billing:read", "salade:read", "salade:post"})
	 * @ORM\ManyToMany(targetEntity="App\Entity\Ingredient", inversedBy="salades", cascade={"persist"})
	 */
	private $ingredients;

	/**
	 * @Groups({"billing:read", "salade:read", "salade:post"})
	 * @ORM\ManyToOne(targetEntity="App\Entity\Sauce", inversedBy="salades", cascade={"persist"})
	 */
	private $sauce;

	/**
	 * @Groups({"billing:read", "salade:read", "salade:post"})
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $createdAt;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Formule", inversedBy="salade", cascade={"persist"})
	 */
	private $formule;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Billing", inversedBy="salade", cascade={"persist"})
	 */
	private $billing;

	/**
	 * @Groups({"billing:read", "salade:post"})
	 * @ORM\OneToOne(targetEntity="App\Entity\Addons", cascade={"persist", "remove"})
	 */
	private $addons;

	/**
	 * @Groups({"salade:read", "salade:post"})
	 * @ORM\ManyToMany(targetEntity="App\Entity\Bread", mappedBy="salades")
	 */
	private $breads;

	public function __construct() {
		$this->ingredients = new ArrayCollection();
		$this->createdAt   = new \DateTime();
		$this->breads      = new ArrayCollection();
	}

	public function __toString() {
		return 'Salade';
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getCreatedAt(): ?\DateTimeInterface {
		return $this->createdAt;
	}

	public function setCreatedAt( \DateTimeInterface $createdAt ): self {
		$this->createdAt = $createdAt;

		return $this;
	}

	public function getBase(): ?Base {
		return $this->base;
	}

	public function setBase( ?Base $base ): self {
		$this->base = $base;

		return $this;
	}

	/**
	 * @return Collection|Ingredient[]
	 */
	public function getIngredients(): Collection {
		return $this->ingredients;
	}

	public function addIngredient( Ingredient $ingredient ): self {
		if ( ! $this->ingredients->contains( $ingredient ) ) {
			$this->ingredients[] = $ingredient;
		}

		return $this;
	}

	public function removeIngredient( Ingredient $ingredient ): self {
		if ( $this->ingredients->contains( $ingredient ) ) {
			$this->ingredients->removeElement( $ingredient );
		}

		return $this;
	}

	public function getSauce(): ?Sauce {
		return $this->sauce;
	}

	public function setSauce( ?Sauce $sauce ): self {
		$this->sauce = $sauce;

		return $this;
	}

	public function getFormule(): ?Formule {
		return $this->formule;
	}

	public function setFormule( ?Formule $formule ): self {
		$this->formule = $formule;

		return $this;
	}

	public function getBilling(): ?Billing {
		return $this->billing;
	}

	public function setBilling( ?Billing $billing ): self {
		$this->billing = $billing;

		return $this;
	}

	public function getAddons(): ?Addons {
		return $this->addons;
	}

	public function setAddons( ?Addons $addons ): self {
		$this->addons = $addons;

		return $this;
	}

	/**
	 * @return Collection|Bread[]
	 */
	public function getBreads(): Collection {
		return $this->breads;
	}

	public function addBread( Bread $bread ): self {
		if ( ! $this->breads->contains( $bread ) ) {
			$this->breads[] = $bread;
			$bread->addSalade( $this );
		}

		return $this;
	}

	public function removeBread( Bread $bread ): self {
		if ( $this->breads->contains( $bread ) ) {
			$this->breads->removeElement( $bread );
			$bread->removeSalade( $this );
		}

		return $this;
	}
}
