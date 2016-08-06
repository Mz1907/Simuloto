<?php

namespace SimulotoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SimulotoBundle\Model\Simulottery;
use SimulotoBundle\Util\ISimulottery;
use Symfony\Component\Config\Tests\Util\Validator as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
/**
 * LotoFrSimulation
 */
class LotoFrSimulation extends Simulottery implements ISimulottery
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $minChance;

    /**
     * @var int
     */
    private $maxChance;

    /**
     * @var int
     */
    private $countDrawChance;

    /**
     * @var array
     */
    private $drawChance;

    /**
     * @var array
     */
    private $uChance;

    /**
     * @var array
     */
    private $goodChance;
    
    public function __construct()
    {
       $this->setName("Loto");
       /** balls **/
       $this->setMinNb(1);
       $this->setMaxNb(49);
       $this->setCountDraw(5);
       
       /** chance **/
       $this->setMinChance(1);
       $this->setMaxChance(10);
       $this->setCountDrawChance(1);
       
       $this->setScore([
           "1" => 0,
           "2" => 0,
           "3" => 0,
           "4" => 0,
           "5" => 0,
           "6" => 0
       ]);       
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set minChance
     *
     * @param integer $minChance
     *
     * @return LotoFrSimulation
     */
    public function setMinChance($minChance)
    {
        $this->minChance = $minChance;

        return $this;
    }

    /**
     * Get minChance
     *
     * @return int
     */
    public function getMinChance()
    {
        return $this->minChance;
    }

    /**
     * Set maxChance
     *
     * @param integer $maxChance
     *
     * @return LotoFrSimulation
     */
    public function setMaxChance($maxChance)
    {
        $this->maxChance = $maxChance;

        return $this;
    }

    /**
     * Get maxChance
     *
     * @return int
     */
    public function getMaxChance()
    {
        return $this->maxChance;
    }

    /**
     * Set countDrawChance
     *
     * @param integer $countDrawChance
     *
     * @return LotoFrSimulation
     */
    public function setCountDrawChance($countDrawChance)
    {
        $this->countDrawChance = $countDrawChance;

        return $this;
    }

    /**
     * Get countDrawChance
     *
     * @return int
     */
    public function getCountDrawChance()
    {
        return $this->countDrawChance;
    }

    /**
     * Set drawChance
     *
     * @param array $drawChance
     *
     * @return LotoFrSimulation
     */
    public function setDrawchance($drawChance)
    {
        $this->drawChance = $drawChance;

        return $this;
    }

    /**
     * Get drawChance
     *
     * @return array
     */
    public function getDrawchance()
    {
        return $this->drawChance;
    }

    /**
     * Set uChance
     *
     * @param array $uChance
     *
     * @return LotoFrSimulation
     */
    public function setUChance($uChance)
    {
        $this->uChance = $uChance;

        return $this;
    }

    /**
     * Get uChance
     *
     * @return array
     */
    public function getUChance()
    {
        return $this->uChance;
    }

    /**
     * Set goodChance
     *
     * @param array $goodChance
     *
     * @return LotoFrSimulation
     */
    public function setGoodChance($goodChance)
    {
        $this->goodChance = $goodChance;

        return $this;
    }

    /**
     * Get goodChance
     *
     * @return array
     */
    public function getGoodChance()
    {
        return $this->goodChance;
    }
}

