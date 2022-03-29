<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Owner
 *
 * @ORM\Table(name="owner")
 * @ORM\Entity(repositoryClass=OwnerRepository::class)
 */
class Owner
{
    /**
     * @var int
     *
     * @ORM\Column(name="owner_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ownerId;

    /**
     * @var string
     *
     * @ORM\Column(name="owner_full_name", type="string", length=50, nullable=false)
     */
    private $ownerFullName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="street_address", type="string", length=50, nullable=true)
     */
    private $streetAddress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="string", length=50, nullable=true)
     */
    private $city;

    /**
     * @var string|null
     *
     * @ORM\Column(name="state", type="string", length=2, nullable=true)
     */
    private $state;

    /**
     * @var int|null
     *
     * @ORM\Column(name="zip_code", type="integer", nullable=true)
     */
    private $zipCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone_num", type="string", length="50", nullable=true)
     */
    private $phoneNum;

    public function getOwnerId(): ?int
    {
        return $this->ownerId;
    }

    public function getOwnerFullName(): ?string
    {
        return $this->ownerFullName;
    }

    public function setOwnerFullName(string $ownerFullName): self
    {
        $this->ownerFullName = $ownerFullName;

        return $this;
    }

    public function getStreetAddress(): ?string
    {
        return $this->streetAddress;
    }

    public function setStreetAddress(?string $streetAddress): self
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(?int $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getPhoneNum(): ?string
    {
        return $this->phoneNum;
    }

    public function setPhoneNum(?string $phoneNum): self
    {
        $this->phoneNum = $phoneNum;

        return $this;
    }


}
