<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BreadRepository")
 * @Vich\Uploadable()
 */
class Bread
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name","id"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="float")
     */
    private $price = 0;

	/**
	 * @var string|null
	 * @Groups({"billing"})
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
	 * @Groups({"billing"})
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Salade", inversedBy="breads")
     */
    private $salades;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active = true;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $short_description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Supplement", mappedBy="breads")
     */
    private $supplements;

    public function __construct()
    {
        $this->salades = new ArrayCollection();
        $this->supplements = new ArrayCollection();
    }

    public function __toString() {
		return $this->getName();
    }

	public function getId(): ?int
                            {
                                return $this->id;
                            }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
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

	/**
     * @return Collection|Salade[]
     */
    public function getSalades(): Collection
    {
        return $this->salades;
    }

    public function addSalade(Salade $salade): self
    {
        if (!$this->salades->contains($salade)) {
            $this->salades[] = $salade;
        }

        return $this;
    }

    public function removeSalade(Salade $salade): self
    {
        if ($this->salades->contains($salade)) {
            $this->salades->removeElement($salade);
        }

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(?string $short_description): self
    {
        $this->short_description = $short_description;

        return $this;
    }

    /**
     * @return Collection|Supplement[]
     */
    public function getSupplements(): Collection
    {
        return $this->supplements;
    }

    public function addSupplement(Supplement $supplement): self
    {
        if (!$this->supplements->contains($supplement)) {
            $this->supplements[] = $supplement;
            $supplement->addBread($this);
        }

        return $this;
    }

    public function removeSupplement(Supplement $supplement): self
    {
        if ($this->supplements->contains($supplement)) {
            $this->supplements->removeElement($supplement);
            $supplement->removeBread($this);
        }

        return $this;
    }
}
