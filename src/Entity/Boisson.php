<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ApiResource(forceEager=false)
 * @ORM\Entity(repositoryClass="App\Repository\BoissonRepository")
 * @Vich\Uploadable()
 * @ORM\HasLifecycleCallbacks()
 */
class Boisson {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Groups({"billing"})
	 */
	private $name;

	/**
	 * @Gedmo\Slug(fields={"name", "id"})
	 * @ORM\Column(type="string", length=255)
	 * @Groups({"billing"})
	 */
	private $slug;

	/**
	 * @ORM\Column(type="float")
	 * @Groups({"billing"})
	 */
	private $price;

	/**
	 * @var string|null
	 * @Groups({"bagel"})
	 * @ORM\Column(type="string",length=255, nullable=true, name="filename")
	 * @Groups({"billing"})
	 */
	private $filename;

	/**
	 * @var File|null
	 * @Vich\UploadableField(mapping="products", fileNameProperty="filename")
	 */
	private $imageFile;

	/**
	 * @var
	 * @ORM\Column(type="datetime", nullable=true)
	 * @Groups({"billing"})
	 */
	private $updatedAt;

	/**
	 * @var bool
	 * @ORM\Column(type="boolean", nullable=false)
	 * @Groups({"billing"})
	 */
	private $is_active = true;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Billing", mappedBy="boissons")
	 * @Groups({"billing"})
	 */
	private $billings;

	public function __construct() {
		$this->billings = new ArrayCollection();
	}

	public function __toString(  ) {
		return $this->getName();
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getName(): ?string {
		return $this->name;
	}

	public function setName( string $name ): self {
		$this->name = $name;

		return $this;
	}

	public function getSlug(): ?string {
		return $this->slug;
	}

	public function setSlug( string $slug ): self {
		$this->slug = $slug;

		return $this;
	}

	public function getPrice(): ?float {
		return $this->price;
	}

	public function setPrice( float $price ): self {
		$this->price = $price;

		return $this;
	}

	public function getFilename(): ?string {
		return $this->filename;
	}

	public function setFilename( ?string $filename ): self {
		$this->filename = $filename;

		return $this;
	}

	/**
	 * @param File|null $imageFile
	 *
	 * @throws \Exception
	 */
	public function setImageFile( ?File $imageFile ): void {
		$this->imageFile = $imageFile;
		if ( $imageFile ) {
			$this->updatedAt = new \DateTime( 'now' );
		}
	}

	/**
	 * @return File|null
	 */
	public function getImageFile(): ?File {
		return $this->imageFile;
	}

	public function getUpdatedAt(): ?\DateTimeInterface {
		return $this->updatedAt;
	}

	public function setUpdatedAt( ?\DateTimeInterface $updatedAt ): self {
		$this->updatedAt = $updatedAt;

		return $this;
	}

	public function getIsActive(): ?bool {
		return $this->is_active;
	}

	public function setIsActive( bool $is_active ): self {
		$this->is_active = $is_active;

		return $this;
	}

	/**
	 * @throws \Exception
	 * @ORM\PreUpdate()
	 */
	public function updateDate() {
		$this->setUpdatedAt( new \DateTime() );
	}

	/**
	 * @return Collection|Billing[]
	 */
	public function getBillings(): Collection {
		return $this->billings;
	}

	public function addBilling( Billing $billing ): self {
		if ( ! $this->billings->contains( $billing ) ) {
			$this->billings[] = $billing;
			$billing->addBoisson( $this );
		}

		return $this;
	}

	public function removeBilling( Billing $billing ): self {
		if ( $this->billings->contains( $billing ) ) {
			$this->billings->removeElement( $billing );
			$billing->removeBoisson( $this );
		}

		return $this;
	}
}
