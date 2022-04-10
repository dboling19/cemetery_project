<?php

namespace App\Entity;

use App\Repository\BurialRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BurialRepository::class)
 */
class Burial
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="boolean")
     */
    private $cremation;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $funeralHome;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $incDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $approval;

    /**
     * @ORM\OneToOne(targetEntity=Plot::class, mappedBy="burial", cascade={"persist", "remove"})
     */
    private $plot;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCremation(): ?bool
    {
        return $this->cremation;
    }

    public function setCremation(bool $cremation): self
    {
        $this->cremation = $cremation;

        return $this;
    }

    public function getFuneralHome(): ?string
    {
        return $this->funeralHome;
    }

    public function setFuneralHome(?string $funeralHome): self
    {
        $this->funeralHome = $funeralHome;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIncDate(): ?string
    {
        return $this->incDate;
    }

    public function setIncDate(?string $incDate): self
    {
        $this->incDate = $incDate;

        return $this;
    }

    public function getApproval(): ?bool
    {
        return $this->approval;
    }

    public function setApproval(bool $approval): self
    {
        $this->approval = $approval;

        return $this;
    }

    public function getPlot(): ?Plot
    {
        return $this->plot;
    }

    public function setPlot(?Plot $plot): self
    {
        // unset the owning side of the relation if necessary
        if ($plot === null && $this->plot !== null) {
            $this->plot->setBurial(null);
        }

        // set the owning side of the relation if necessary
        if ($plot !== null && $plot->getBurial() !== $this) {
            $plot->setBurial($this);
        }

        $this->plot = $plot;

        return $this;
    }
}
