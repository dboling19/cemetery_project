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
    private $burialDate;

    /**
     * @var string|null
     * 
     * @ORM\Column(name="incomplete_date", type="string", nullable=true)
     */
    private $incompleteDate;

    /**
     * @var int|null
     * 
     * @ORM\Column(name="approval", type="integer", nullable=false)
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

    public function getBurialDate(): ?\DateTimeInterface
    {
        return $this->burialDate;
    }

    public function setBurialDate(\DateTimeInterface $burialDate): self
    {
        $this->burialDate = $burialDate;

        return $this;
    }

    public function getIncompleteDate(): ?\DateTimeInterface
    {
        return $this->incompleteDate;
    }

    public function setIncompleteDate(\DateTimeInterface $incompleteDate): self
    {
        $this->incompleteDate = $incompleteDate;

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
