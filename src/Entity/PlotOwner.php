<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlotOwner
 *
 * @ORM\Table(name="plot_owner")
 * @ORM\Entity(repositoryClass=PlotOwnerRepository::class)
 */
class PlotOwner
{
    /**
     * @var int
     *
     * @ORM\Column(name="table_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $tableId;

    /**
     * @var int
     *
     * @ORM\Column(name="owner_id", type="integer", nullable=false)
     */
    private $ownerId;

    /**
     * @var int
     *
     * @ORM\Column(name="plot_id", type="integer", nullable=false)
     */
    private $plotId;

    /**
     * @var bool
     * 
     * @ORM\Column(name="notarized", type="boolean", nullable=false)
     */
    private $notarized;

    /**
     * @var bool
     * 
     * @ORM\Column(name="approved", type="boolean", nullable=false)
     */

    /**
     * @var \DateTimeInterface|null
     * 
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    public function getTableId(): ?int
    {
        return $this->tableId;
    }

    public function getOwnerId(): ?int
    {
        return $this->ownerId;
    }

    public function setOwnerId(int $ownerId): self
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    public function getPlotId(): ?int
    {
        return $this->plotId;
    }

    public function setPlotId(int $plotId): self
    {
        $this->plotId = $plotId;

        return $this;
    }

    public function getNotarized(): ?bool
    {
        return $this->notarized;
    }

    public function setNotarized(bool $notarized): self
    {
        $this->notarized = $notarized;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }


}
