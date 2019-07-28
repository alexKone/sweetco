<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Controller\FormuleCollectionController;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(forceEager=false)
 * @ORM\Entity(repositoryClass="App\Repository\FormuleRepository")
 * @Vich\Uploadable()
 * @ORM\HasLifecycleCallbacks()
 */
class Formule {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @ORM\OrderBy({"order"=""})
	 * @Groups({"billing"})
	 */
	private $name;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 * @Groups({"billing"})
	 */
	private $description;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @Groups({"billing"})
	 */
	private $short_description;

	/**
	 * @ORM\Column(type="integer")
	 * @Groups({"billing"})
	 */
	private $limit_base = 1;

	/**
	 * @ORM\Column(type="integer")
	 * @Groups({"billing"})
	 */
	private $limit_ingredient = 4;

	/**
	 * @ORM\Column(type="integer")
	 * @Groups({"billing"})
	 */
	private $limit_sauce = 1;

	/**
	 * @ORM\Column(type="boolean")
	 * @Groups({"billing"})
	 */
	private $has_bagel = false;

	/**
	 * @ORM\Column(type="boolean")
	 * @Groups({"billing"})
	 */
	private $has_panini = false;

	/**
	 * @var string|null
	 * @Groups({"billing"})
	 * @ORM\Column(type="string", length=255, nullable=true, name="formule_filename")
	 */
	private $formuleFilename;

	/**
	 * @var File|null
	 * @Vich\UploadableField(mapping="products", fileNameProperty="formuleFilename")
	 */
	private $imageFile;

	/**
	 * @var
	 * @ORM\Column(type="datetime")
	 * @Groups({"billing"})
	 */
	private $createdAt;

	/**
	 * @var
	 * @ORM\Column(type="datetime", nullable=true)
	 * @Groups({"billing"})
	 */
	private $updatedAt;

	/**
	 * @ORM\Column(type="float")
	 * @Groups({"billing"})
	 */
	private $price;

	/**
	 * @Gedmo\Slug(fields={"name","id"})
	 * @ORM\Column(type="string", length=255, nullable=false)
	 * @Groups({"billing"})
	 */
	private $slug;

	/**
	 * @Groups({"billing"})
	 * @ORM\Column(type="boolean", nullable=true, options={"default": false})
	 */
	private $has_boisson = false;

	/**
	 * @Groups({"billing"})
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $has_dessert = false;

	/**
	 * @Groups({"billing"})
	 * @ORM\OneToMany(targetEntity="App\Entity\Salade", mappedBy="formule")
	 * @ApiSubresource(maxDepth=6)
	 */
	private $salades;

	/**
	 * @var bool
	 * @Groups({"billing"})
	 * @ORM\Column(type="boolean", nullable=false)
	 */
	private $is_active = true;

	/**
	 * @Groups({"formule"})
	 * @ORM\ManyToMany(targetEntity="App\Entity\Billing", mappedBy="formules")
	 * @ApiSubresource(maxDepth=6)
	 */
	private $billings;

	/**
	 * @Groups({"billing"})
	 * @ORM\Column(type="boolean")
	 */
	private $has_salade = false;

	public function __construct() {
		$this->createdAt = new \DateTime();
		$this->orders    = new ArrayCollection();
		$this->salade    = new ArrayCollection();
		$this->salades   = new ArrayCollection();
		$this->billings  = new ArrayCollection();
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

	public function getDescription(): ?string {
		return $this->description;
	}

	public function setDescription( ?string $description ): self {
		$this->description = $description;

		return $this;
	}

	public function getShortDescription(): ?string {
		return $this->short_description;
	}

	public function setShortDescription( ?string $short_description ): self {
		$this->short_description = $short_description;

		return $this;
	}

	public function getLimitBase(): ?int {
		return $this->limit_base;
	}

	public function setLimitBase( int $limit_base ): self {
		$this->limit_base = $limit_base;

		return $this;
	}

	public function getLimitIngredient(): ?int {
		return $this->limit_ingredient;
	}

	public function setLimitIngredient( int $limit_ingredient ): self {
		$this->limit_ingredient = $limit_ingredient;

		return $this;
	}

	public function getLimitSauce(): ?int {
		return $this->limit_sauce;
	}

	public function setLimitSauce( int $limit_sauce ): self {
		$this->limit_sauce = $limit_sauce;

		return $this;
	}

	public function getHasBagel(): ?bool {
		return $this->has_bagel;
	}

	public function setHasBagel( bool $has_bagel ): self {
		$this->has_bagel = $has_bagel;

		return $this;
	}

	public function getHasPanini(): ?bool {
		return $this->has_panini;
	}

	public function setHasPanini( bool $has_panini ): self {
		$this->has_panini = $has_panini;

		return $this;
	}


	/**
	 * @return string|null
	 */
	public function getFormuleFilename(): ?string {
		return $this->formuleFilename;
	}

	/**
	 * @param string|null $filename
	 *
	 * @return Formule
	 */
	public function setFormuleFilename( ?string $filename ) {
		$this->formuleFilename = $filename;

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
	 * @return void
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
	 * @return Formule
	 */
	public function setUpdatedAt( $updatedAt ) {
		$this->updatedAt = $updatedAt;

		return $this;
	}

	public function getCreatedAt(): ?\DateTimeInterface {
		return $this->createdAt;
	}

	public function setCreatedAt( \DateTimeInterface $createdAt ): self {
		$this->createdAt = $createdAt;

		return $this;
	}

	public function getPrice(): ?float {
		return $this->price;
	}

	public function setPrice( float $price ): self {
		$this->price = $price;

		return $this;
	}

	public function getSlug(): ?string {
		return $this->slug;
	}

	public function setSlug( ?string $slug ): self {
		$this->slug = $slug;

		return $this;
	}

	public function getHasBoisson(): ?bool {
		return $this->has_boisson;
	}

	public function setHasBoisson( ?bool $has_boisson ): self {
		$this->has_boisson = $has_boisson;

		return $this;
	}

	public function getHasDessert(): ?bool {
		return $this->has_dessert;
	}

	public function setHasDessert( ?bool $has_dessert ): self {
		$this->has_dessert = $has_dessert;

		return $this;
	}

	/**
	 * @return Collection|Salade[]
	 */
	public function getSalade(): Collection {
		return $this->salade;
	}

	public function addSalade( Salade $salade ): self {
		if ( ! $this->salade->contains( $salade ) ) {
			$this->salade[] = $salade;
			$salade->setFormule( $this );
		}

		return $this;
	}

	public function removeSalade( Salade $salade ): self {
		if ( $this->salade->contains( $salade ) ) {
			$this->salade->removeElement( $salade );
			// set the owning side to null (unless already changed)
			if ( $salade->getFormule() === $this ) {
				$salade->setFormule( null );
			}
		}

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
	 * @return Collection|Salade[]
	 */
	public function getSalades(): Collection {
		return $this->salades;
	}

	/**
	 * @throws \Exception
	 * @ORM\PreUpdate()
	 */
	public function updateDate() {
		$this->setUpdatedAt( new DateTime() );
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
			$billing->addFormule( $this );
		}

		return $this;
	}

	public function removeBilling( Billing $billing ): self {
		if ( $this->billings->contains( $billing ) ) {
			$this->billings->removeElement( $billing );
			$billing->removeFormule( $this );
		}

		return $this;
	}

	public function getHasSalade(): ?bool {
		return $this->has_salade;
	}

	public function setHasSalade( bool $has_salade ): self {
		$this->has_salade = $has_salade;

		return $this;
	}

}
