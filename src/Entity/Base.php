<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BaseRepository")
 * @Vich\Uploadable()
 * @ORM\HasLifecycleCallbacks()
 */
class Base {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 * @Groups({"base:read", "formule.container:post"})
	 */
	private $id;

	/**
	 * @Groups({"base:read", "billing:read", "salade:post", "formule.container:post"})
	 * @ORM\Column(type="string", length=255)
	 */
	private $name;

	/**
	 * @Groups({"base:read", "billing:read", "salade:post", "formule.container:post"})
	 * @var string|null
	 * @ORM\Column(type="string", length=255, nullable=true)
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
	 * @Groups({"base:read", "billing:read", "salade:post"})
	 */
	private $updatedAt;

	/**
	 * @var bool
	 * @ORM\Column(type="boolean", nullable=false)
	 * @Groups({"base:read", "billing:read", "salade:post", "formule.container:post"})
	 */
	private $is_active = true;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Salade", mappedBy="base")
	 */
	private $salades;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Addons", mappedBy="bases")
	 */
	private $addons;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Supplement", mappedBy="bases")
	 */
	private $supplements;

	public function __construct() {
		$this->salades     = new ArrayCollection();
		$this->addons      = new ArrayCollection();
		$this->supplements = new ArrayCollection();
	}

	public function __toString() {
		return $this->name;
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

	/**
	 * @return Collection|Salade[]
	 */
	public function getSalades(): Collection {
		return $this->salades;
	}

	public function addSalade( Salade $salade ): self {
		if ( ! $this->salades->contains( $salade ) ) {
			$this->salades[] = $salade;
			$salade->setBase( $this );
		}

		return $this;
	}

	public function removeSalade( Salade $salade ): self {
		if ( $this->salades->contains( $salade ) ) {
			$this->salades->removeElement( $salade );
			// set the owning side to null (unless already changed)
			if ( $salade->getBase() === $this ) {
				$salade->setBase( null );
			}
		}

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getFilename(): ?string {
		return $this->filename;
	}

	/**
	 * @param string|null $filename
	 *
	 * @return Base
	 */
	public function setFilename( ?string $filename ) {
		$this->filename = $filename;

		return $this;
	}

	/**
	 * @return File|null
	 */
	public function getImageFile(): ?File {
		return $this->imageFile;
	}

	/**
	 * @param File|null $imageFile
	 *
	 * @return Base
	 * @throws \Exception
	 */
	public function setImageFile( ?File $imageFile = null ): void {
		$this->imageFile = $imageFile;
		if ( $imageFile ) {
			$this->updatedAt = new \DateTime( 'now' );
		}
	}

	/**
	 * @return mixed
	 */
	public function getUpdatedAt() {
		return $this->updatedAt;
	}

	/**
	 * @param mixed $updatedAt
	 *
	 * @return Base
	 */
	public function setUpdatedAt( $updatedAt ) {
		$this->updatedAt = $updatedAt;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isActive(): bool {
		return $this->is_active;
	}

	/**
	 * @param bool $is_active
	 *
	 * @return Base
	 */
	public function setIsActive( bool $is_active ): Base {
		$this->is_active = $is_active;

		return $this;
	}

	public function getIsActive(): ?bool {
		return $this->is_active;
	}

	/**
	 * @throws \Exception
	 * @ORM\PreUpdate()
	 */
	public function updateDate() {
		$this->setUpdatedAt( new \DateTime() );
	}

	/**
	 * @return Collection|Addons[]
	 */
	public function getAddons(): Collection {
		return $this->addons;
	}

	public function addAddon( Addons $addon ): self {
		if ( ! $this->addons->contains( $addon ) ) {
			$this->addons[] = $addon;
			$addon->addBasis( $this );
		}

		return $this;
	}

	public function removeAddon( Addons $addon ): self {
		if ( $this->addons->contains( $addon ) ) {
			$this->addons->removeElement( $addon );
			$addon->removeBasis( $this );
		}

		return $this;
	}

	/**
	 * @return Collection|Supplement[]
	 */
	public function getSupplements(): Collection {
		return $this->supplements;
	}

	public function addSupplement( Supplement $supplement ): self {
		if ( ! $this->supplements->contains( $supplement ) ) {
			$this->supplements[] = $supplement;
			$supplement->addBasis( $this );
		}

		return $this;
	}

	public function removeSupplement( Supplement $supplement ): self {
		if ( $this->supplements->contains( $supplement ) ) {
			$this->supplements->removeElement( $supplement );
			$supplement->removeBasis( $this );
		}

		return $this;
	}
}
