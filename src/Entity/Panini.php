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
 * @ORM\Entity(repositoryClass="App\Repository\PaniniRepository")
 * @Vich\Uploadable()
 */
class Panini {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 * @Groups({"panini:read", "formule.container:post"})
	 */
	private $id;

	/**
	 * @Groups({"panini:read", "billing:read", "formule.container:post"})
	 * @ORM\Column(type="string", length=255)
	 */
	private $name;

	/**
	 * @Groups({"panini:read", "billing:read", "formule.container:post"})
	 * @ORM\Column(type="string", length=255)
	 * @Gedmo\Slug(fields={"name","id"})
	 */
	private $slug;

	/**
	 * @var
	 * @Groups({"panini:read", "billing:read", "formule.container:post"})
	 * @ORM\Column(type="string")
	 */
	private $short_description;

	/**
	 * @Groups({"panini:read", "billing:read", "formule.container:post"})
	 * @ORM\Column(type="float")
	 */
	private $price;

	/**
	 * @var string|null
	 * @Groups({"panini:read", "billing:read", "formule.container:post"})
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
	 * @Groups({"panini:read", "billing:read", "formule.container:post"})
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $updatedAt;

	/**
	 * @var bool
	 * @Groups({"panini:read", "billing:read", "formule.container:post"})
	 * @ORM\Column(type="boolean", nullable=false)
	 */
	private $is_active = true;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Billing", mappedBy="paninis")
	 */
	private $billings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FormuleContainer", mappedBy="panini")
     */
    private $formuleContainers;


	public function __construct() {
      		$this->billings = new ArrayCollection();
        $this->formuleContainers = new ArrayCollection();
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

	public function getIsActive(): ?bool {
      		return $this->is_active;
      	}

	public function setIsActive( bool $is_active ): self {
      		$this->is_active = $is_active;

      		return $this;
      	}

	public function getShortDescription(): ?string {
      		return $this->short_description;
      	}

	public function setShortDescription( string $short_description ): self {
      		$this->short_description = $short_description;

      		return $this;
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
      			$billing->addPanini( $this );
      		}

      		return $this;
      	}

	public function removeBilling( Billing $billing ): self {
      		if ( $this->billings->contains( $billing ) ) {
      			$this->billings->removeElement( $billing );
      			$billing->removePanini( $this );
      		}

      		return $this;
      	}

	/**
	 * @return Collection|FormuleContainer[]
	 */
	public function getFormuleContainers(): Collection {
      		return $this->formuleContainers;
      	}

	public function addFormuleContainer( FormuleContainer $formuleContainer ): self {
      		if ( ! $this->formuleContainers->contains( $formuleContainer ) ) {
      			$this->formuleContainers[] = $formuleContainer;
      			$formuleContainer->setPaninis( $this );
      		}

      		return $this;
      	}

	public function removeFormuleContainer( FormuleContainer $formuleContainer ): self {
      		if ( $this->formuleContainers->contains( $formuleContainer ) ) {
      			$this->formuleContainers->removeElement( $formuleContainer );
      			// set the owning side to null (unless already changed)
      			if ( $formuleContainer->getPaninis() === $this ) {
      				$formuleContainer->setPaninis( null );
      			}
      		}

      		return $this;
      	}


}
