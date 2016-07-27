<?php

namespace SimulotoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SimulotoBundle\Model\Simulottery;
use SimulotoBundle\Util\ISimulottery;

/**
 * LottoSimulation
 *
 * @ORM\Table(name="lotto_simulation")
 * @ORM\Entity(repositoryClass="SimulotoBundle\Repository\LottoSimulationRepository")
 */
class LottoSimulation extends Simulottery implements ISimulottery
{

    /**
     * Construct
     * 
     * @param integer $min
     * @param integer $max
     */
    public function __construct()
    {
        $this->minNb = 1;
        $this->maxNb = 45;
    }

    /**
     * draw() build a Lotto draw between minNb and maxNb
     * 
     * @return array
     */
    public function draw()
    {
        $drawTemp = [];

        do
        {
            $tempNb = mt_rand($this->minNb, $this->maxNb);
            if (!in_array($tempNb, $drawTemp))
            {
                $drawTemp[] = $tempNb;
            }
        } while (count($drawTemp) < 6);
    }

}
