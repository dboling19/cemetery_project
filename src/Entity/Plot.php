<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\OneToOne;

/**
 * Plot
 *
 * @ORM\Table(name="plot")
 * @ORM\Entity(repositoryClass=PlotRepository::class)
 */
class Plot
{
    /**
     * @var int
     *
     * @ORM\Column(name="plot_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $plotId;

    /**
     * @var \Burial|null
     * 
     * @ORM\Column(name="burial", type="integer", nullable=true)
     * @ORM\OneToOne(targetEntity="Burial")
     */
    private $burial;
    
    /**
     * @var string
     *
     * @ORM\Column(name="cemetery", type="string", length=50, nullable=false)
     */
    private $cemetery;

    /**
     * @var string|null
     *
     * @ORM\Column(name="section", type="string", length=10, nullable=true)
     */
    private $section;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lot", type="string", length=10, nullable=true)
     */
    private $lot;

    /**
     * @var string|null
     *
     * @ORM\Column(name="space", type="string", length=10, nullable=true)
     */
    private $space;

    /**
     * @var string|null
     *
     * @ORM\Column(name="notes", type="text", length=16, nullable=true)
     */
    private $notes;

    /**
     * @var bool
     * 
     * @ORM\Column(name="approval", type="boolean")
     */
    private $approval;


    public function getPlotId(): ?int
    {
        return $this->plotId;
    }

    public function getBurial(): ?Burial
    {
        return $this->burial;
    }

    public function setBurial(?Burial $burial): self
    {
        $this->burial = $burial;

        return $this;
    }

    public function getCemetery(): ?string
    {
        return $this->cemetery;
    }

    public function setCemetery(string $cemetery): self
    {
        $this->cemetery = $cemetery;

        return $this;
    }

    public function getSection(): ?string
    {
        return $this->section;
    }

    public function setSection(?string $section): self
    {
        $this->section = $section;

        return $this;
    }

    public function getLot(): ?string
    {
        return $this->lot;
    }

    public function setLot(?string $lot): self
    {
        $this->lot = $lot;

        return $this;
    }

    public function getSpace(): ?string
    {
        return $this->space;
    }

    public function setSpace(?string $space): self
    {
        $this->space = $space;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getApproval(): ?bool
    {
        return $this->approval;
    }

    public function setApproval(?bool $approval): self
    {
        $this->approval = $approval;

        return $this;
    }


}
