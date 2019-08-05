<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FormuleContainerRepository")
 */
class FormuleContainer {
	/**
	 * @Groups({"formule.container:post", "billing:read"})
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Formule", inversedBy="formuleContainers")
	 */
	private $formule;

	/**
	 * @Groups({"formule.container:post", "billing:read"})
	 * @ORM\OneToOne(targetEntity="App\Entity\Salade", cascade={"persist", "remove"})
	 */
	private $salade;

	/**
	 * @Groups({"formule.container:post", "billing:read"})
	 * @ORM\ManyToOne(targetEntity="App\Entity\Bagel", inversedBy="formuleContainers")
	 */
	private $bagel;

	/**
	 * @Groups({"formule.container:post", "billing:read"})
	 * @ORM\ManyToOne(targetEntity="App\Entity\Panini", inversedBy="formuleContainers")
	 */
	private $panini;

	/**
	 * @Groups({"formule.container:post", "billing:read"})
	 * @ORM\ManyToOne(targetEntity="App\Entity\Boisson", inversedBy="formuleContainers")
	 */
	private $boisson;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Billing", inversedBy="formule_container")
	 */
	private $billing;

	/**
	 * @Groups({"formule.container:post", "billing:read"})
	 * @ORM\OneToOne(targetEntity="App\Entity\Supplement", cascade={"persist", "remove"})
	 */
	private $supplement;

    /**
     * @Groups({"formule.container:post", "billing:read"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Dessert", inversedBy="formuleContainers")
     */
    private $desserts;

    /**
     * @Groups({"formule.container:post", "billing:read"})
     * @ORM\Column(type="float")
     */
    private $price;

    public function __construct()
    {
        $this->desserts = new ArrayCollection();
    }

	public function __toString() {
                                 		return 'Formule Container '. $this->getId();
                                 	}

	public function getId(): ?int {
                                 		return $this->id;
                                 	}

	public function getFormule(): ?Formule {
                                 		return $this->formule;
                                 	}

	public function setFormule( ?Formule $formule ): self {
                                 		$this->formule = $formule;

                                 		return $this;
                                 	}

	public function getSalade(): ?Salade {
                                 		return $this->salade;
                                 	}

	public function setSalade( ?Salade $salade ): self {
                                 		$this->salade = $salade;

                                 		return $this;
                                 	}

	public function getBagel(): ?Bagel {
                                 		return $this->bagel;
                                 	}

	public function setBagel( ?Bagel $bagel ): self {
                                 		$this->bagel = $bagel;

                                 		return $this;
                                 	}

	public function getPanini(): ?Panini {
                                 		return $this->panini;
                                 	}

	public function setPanini( ?Panini $panini ): self {
                                 		$this->panini = $panini;

                                 		return $this;
                                 	}

	public function getBoisson(): ?Boisson {
                                 		return $this->boisson;
                                 	}

	public function setBoisson( ?Boisson $boisson ): self {
                                 		$this->boisson = $boisson;

                                 		return $this;
                                 	}

	public function getBilling(): ?Billing {
                                 		return $this->billing;
                                 	}

	public function setBilling( ?Billing $billing ): self {
                                 		$this->billing = $billing;

                                 		return $this;
                                 	}

	public function getSupplement(): ?Supplement {
                                 		return $this->supplement;
                                 	}

	public function setSupplement( ?Supplement $supplement ): self {
                                 		$this->supplement = $supplement;

                                 		return $this;
                                 	}

    /**
     * @return Collection|Dessert[]
     */
    public function getDesserts(): Collection
    {
        return $this->desserts;
    }

    public function addDessert(Dessert $dessert): self
    {
        if (!$this->desserts->contains($dessert)) {
            $this->desserts[] = $dessert;
        }

        return $this;
    }

    public function removeDessert(Dessert $dessert): self
    {
        if ($this->desserts->contains($dessert)) {
            $this->desserts->removeElement($dessert);
        }

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
}
