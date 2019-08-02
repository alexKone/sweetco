<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FormuleContainerRepository")
 */
class FormuleContainer
{
    /**
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
     * @ORM\OneToOne(targetEntity="App\Entity\Salade", cascade={"persist", "remove"})
     */
    private $salade;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bagel", inversedBy="formuleContainers")
     */
    private $bagel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Panini", inversedBy="formuleContainers")
     */
    private $panini;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Boisson", inversedBy="formuleContainers")
     */
    private $boisson;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormule(): ?Formule
    {
        return $this->formule;
    }

    public function setFormule(?Formule $formule): self
    {
        $this->formule = $formule;

        return $this;
    }

    public function getSalade(): ?Salade
    {
        return $this->salade;
    }

    public function setSalade(?Salade $salade): self
    {
        $this->salade = $salade;

        return $this;
    }

    public function getBagel(): ?Bagel
    {
        return $this->bagel;
    }

    public function setBagel(?Bagel $bagel): self
    {
        $this->bagel = $bagel;

        return $this;
    }

    public function getPanini(): ?Panini
    {
        return $this->panini;
    }

    public function setPanini(?Panini $panini): self
    {
        $this->panini = $panini;

        return $this;
    }

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }
}
