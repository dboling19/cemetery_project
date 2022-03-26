<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlotOwner
 *
 * @ORM\Table(name="plot_owner")
 * @ORM\Entity
 */
class PlotOwner
{
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
     * @var \PlotOwner
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\OneToOne(targetEntity="PlotOwner")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="table_id", referencedColumnName="table_id")
     * })
     */
    private $table;

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

    public function getTable(): ?self
    {
        return $this->table;
    }

    public function setTable(?self $table): self
    {
        $this->table = $table;

        return $this;
    }


}
