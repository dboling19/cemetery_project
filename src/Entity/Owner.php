<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Owner
 *
 * @ORM\Table(name="owner")
 * @ORM\Entity
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


}
