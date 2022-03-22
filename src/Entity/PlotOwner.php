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
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $ownerId;

    /**
     * @var int
     *
     * @ORM\Column(name="plot_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $plotId;

    public function getOwnerId(): ?int
    {
        return $this->ownerId;
    }

    public function getPlotId(): ?int
    {
        return $this->plotId;
    }


}
