<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Burial
 *
 * @ORM\Table(name="burial")
 * @ORM\Entity(repositoryClass=BurialRepository::class)
 */
class Burial
{
    /**
     * @var int
     *
     * @ORM\Column(name="burial_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $burialId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="first_name", type="string", length=50, nullable=true)
     */
    private $firstName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="last_name", type="string", length=50, nullable=true)
     */
    private $lastName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="burial_month", type="string", length=10, nullable=true)
     */
    private $burialMonth;

    /**
     * @var string|null
     *
     * @ORM\Column(name="burial_day", type="string", length=10, nullable=true)
     */
    private $burialDay;

    /**
     * @var string|null
     *
     * @ORM\Column(name="burial_year", type="string", length=10, nullable=true)
     */
    private $burialYear;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cremation", type="smallint", nullable=true)
     */
    private $cremation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="funeral_home", type="string", length=50, nullable=true)
     */
    private $funeralHome;

    /**
     * @var \DateTimeInterface|null
     * 
     * @ORM\Column(name="burial_date", type="date", nullable=true)
     */
    private $date;

    /**
     * @var int|null
     * 
     * @ORM\Column(name="approval", type="integer", nullable=true)
     */
    private $approval;

    
    public function getBurialId(): ?int
    {
        return $this->burialId;
    }

    public function setBurialId(?int $burialId): self
    {
        $this->burialId = $burialId;

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

    public function getBurialMonth(): ?string
    {
        return $this->burialMonth;
    }

    public function setBurialMonth(?string $burialMonth): self
    {
        $this->burialMonth = $burialMonth;

        return $this;
    }

    public function getBurialDay(): ?string
    {
        return $this->burialDay;
    }

    public function setBurialDay(?string $burialDay): self
    {
        $this->burialDay = $burialDay;

        return $this;
    }

    public function getBurialYear(): ?string
    {
        return $this->burialYear;
    }

    public function setBurialYear(?string $burialYear): self
    {
        $this->burialYear = $burialYear;

        return $this;
    }

    public function getCremation(): ?int
    {
        return $this->cremation;
    }

    public function setCremation(?int $cremation): self
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

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getApproval(): ?int
    {
        return $this->approval;
    }

    public function setApproval(?int $approval): self
    {
        $this->approval = $approval;

        return $this;
    }


}
