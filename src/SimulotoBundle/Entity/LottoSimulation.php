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
    
    protected $hasComp;
    
    
    
    /**
     * Construct
     * 
     * @param integer $min
     * @param integer $max
     */
    public function __construct()
    {
        $this->setName("Lotto");
        
        $this->setMinNb(1);
        
        $this->setMaxNb(45);
        
        $this->setCountDraw(7);
        
        $this->setScore([
            "1" => 0,
            "2" => 0,
            "3" => 0,
            "4" => 0,
            "5" => 0,
            "6" => 0,
            "7" => 0,
            "8" => 0
        ]);
    }
    
        /**
     * Set uNumbers
     *
     * @param boolean $hasComp
     *
     * @return Simulottery
     */
    public function setHasComp($hasComp)
    {
        $this->hasComp = $hasComp;

        return $this;
    }

    /**
     * Get hasComp
     *
     * @return boolean
     */
    public function getHasComp()
    {
        return $this->hasComp;
    }

}
