<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlotOwner
 *
 * @ORM\Table(name="plot_burial")
 * @ORM\Entity(repositoryClass=PlotBurialRepository::class)
 */
class PlotBurial
{
    /**
     * @var int
     *
     * @ORM\Column(name="table_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $tableId;

    /**
     * @var int
     *
     * @ORM\Column(name="burial_id", type="integer", nullable=false)
     */
    private $burialId;

    /**
     * @var int
     *
     * @ORM\Column(name="plot_id", type="integer", nullable=false)
     */
    private $plotId;

    /**
     * @var int
     * 
     * @ORM\Column(name="approval", type="integer", nullable=false)
     */
    private $approval;

    /**
     * @var \DateTimeInterface|null
     * 
     * @ORM\Column(name="burial_date", type="date", nullable=true)
     */
    private $burial_date;

    public function getTableId(): ?int
    {
        return $this->tableId;
    }

    public function getBurialId(): ?int
    {
        return $this->burialId;
    }

    public function setBurialId(int $burialId): self
    {
        $this->burialId = $burialId;

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

    public function getApproval(): ?int
    {
        return $this->approval;
    }

    public function setApproval(int $approval): self
    {
        $this->approval = $approval;

        return $this;
    }

    public function getBurialDate(): ?\DateTimeInterface
    {
        return $this->burial_date;
    }

    public function setdate(\DateTimeInterface $burial_date): self
    {
        $this->burial_date = $burial_date;

        return $this;
    }


}
