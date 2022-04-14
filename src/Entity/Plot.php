<?php

namespace App\Entity;

use App\Repository\PlotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlotRepository::class)
 */
class Plot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $cemetery;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $section;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $lot;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $space;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\Column(type="integer")
     */
    private $approval;

    /**
     * @ORM\OneToOne(targetEntity=Burial::class, inversedBy="plot", cascade={"persist", "remove"})
     */
    private $burial;

    /**
     * @ORM\ManyToMany(targetEntity=Owner::class, inversedBy="plots")
     */
    private $owner;

    public function __construct()
    {
        $this->owner = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getCemetery(): ?string
    {
        return $this->cemetery;
    }

    public function setCemetery(?string $cemetery): self
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

    public function getApproval(): ?int
    {
        return $this->approval;
    }

    public function setApproval(int $approval): self
    {
        $this->approval = $approval;

        return $this;
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

    /**
     * @return Collection<int, Owner>
     */
    public function getOwner(): Collection
    {
        return $this->owner;
    }

    public function addOwner(Owner $owner): self
    {
        if (!$this->owner->contains($owner)) {
            $this->owner[] = $owner;
        }

        return $this;
    }

    public function removeOwner(Owner $owner): self
    {
        $this->owner->removeElement($owner);

        return $this;
    }
}
