<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BagelRepository")
 * @Vich\Uploadable()
 * @ORM\HasLifecycleCallbacks()
 */
class Bagel {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 * @Groups({"bagel:read"})
	 */
	private $id;

	/**
	 * @Groups({"bagel:read", "billing"})
	 * @ORM\Column(type="string", length=255)
	 */
	private $name;

	/**
	 * @Gedmo\Slug(fields={"name","id"})
	 * @ORM\Column(type="string", length=255)
	 * @Groups({"bagel:read", "billing"})
	 */
	private $slug;

	/**
	 * @ORM\Column(type="float")
	 * @Groups({"bagel:read", "billing"})
	 */
	private $price = 0;

	/**
	 * @var string|null
	 * @Groups({"bagel:read", "billing"})
	 * @ORM\Column(type="string",length=255, nullable=true, name="filename")
	 */
	private $filename;

	/**
	 * @var File|null
	 * @Vich\UploadableField(mapping="products", fileNameProperty="filename")
	 */
	private $imageFile;

	/**
	 * @var
	 * @Groups({"bagel:read", "billing"})
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $updatedAt;

	/**
	 * @Groups({"bagel:read", "billing"})
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $short_description;

	/**
	 * @var bool
	 * @Groups({"bagel:read", "billing"})
	 * @ORM\Column(type="boolean", nullable=false)
	 */
	private $is_active = true;

	/**
	 * @Groups({"bagel:read", "billing"})
	 * @ORM\ManyToMany(targetEntity="App\Entity\Billing", mappedBy="bagels")
	 */
	private $billings;

	public function __construct() {
		$this->billings = new ArrayCollection();
	}

	public function __toString() {
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

	public function getShortDescription(): ?string {
		return $this->short_description;
	}

	public function setShortDescription( ?string $short_description ): self {
		$this->short_description = $short_description;

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
			$billing->addBagel( $this );
		}

		return $this;
	}

	public function removeBilling( Billing $billing ): self {
		if ( $this->billings->contains( $billing ) ) {
			$this->billings->removeElement( $billing );
			$billing->removeBagel( $this );
		}

		return $this;
	}
}
