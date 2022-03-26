<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Burial
 *
 * @ORM\Table(name="burial")
 * @ORM\Entity
 */
class Burial
{
    /**
     * @var int
     *
     * @ORM\Column(name="burial_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $burialId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="burial_first", type="string", length=50, nullable=true)
     */
    private $burialFirst;

    /**
     * @var string|null
     *
     * @ORM\Column(name="burial_last", type="string", length=50, nullable=true)
     */
    private $burialLast;

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

    public function getBurialId(): ?int
    {
        return $this->burialId;
    }

    public function getBurialFirst(): ?string
    {
        return $this->burialFirst;
    }

    public function setBurialFirst(?string $burialFirst): self
    {
        $this->burialFirst = $burialFirst;

        return $this;
    }

    public function getBurialLast(): ?string
    {
        return $this->burialLast;
    }

    public function setBurialLast(?string $burialLast): self
    {
        $this->burialLast = $burialLast;

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


}
