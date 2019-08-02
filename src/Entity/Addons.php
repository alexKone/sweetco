<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AddonsRepository")
 */
class Addons {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Base", inversedBy="addons", cascade={"persist"})
	 * @Groups({"billing"})
	 */
	private $bases;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Ingredient", inversedBy="addons", cascade={"persist"})
	 * @Groups({"billing"})
	 */
	private $ingredients;

	public function __construct() {
		$this->bases       = new ArrayCollection();
		$this->ingredients = new ArrayCollection();
	}

	public function getId(): ?int {
		return $this->id;
	}

	/**
	 * @return Collection|Base[]
	 */
	public function getBases(): Collection {
		return $this->bases;
	}

	public function addBasis( Base $basis ): self {
		if ( ! $this->bases->contains( $basis ) ) {
			$this->bases[] = $basis;
		}

		return $this;
	}

	public function removeBasis( Base $basis ): self {
		if ( $this->bases->contains( $basis ) ) {
			$this->bases->removeElement( $basis );
		}

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
}
