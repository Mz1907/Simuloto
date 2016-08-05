<?php

namespace SimulotoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SimulotoBundle\Model\Simulottery;
use SimulotoBundle\Util\ISimulottery;
use Symfony\Component\Config\Tests\Util\Validator as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Euromillions
 */
class EuromillionsSimulation extends Simulottery implements ISimulottery
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $minStars;

    /**
     * @var int
     */
    private $maxStars;

    /**
     * @var int
     */
    private $countDrawStars;

    /**
     * @var array
     */
    private $drawStars;

    /**
     * @var array
     */
    private $uStars;

    /**
     * @var array
     */
    private $goodStars;
    
    public function __construct()
    {
       $this->setName("Euromillions");
       /** balls **/
       $this->setMinNb(1);
       $this->setMaxNb(50);
       $this->setCountDraw(5);
       
       /** stars **/
       $this->setMinStars(1);
       $this->setMaxStars(11);
       $this->setCountDrawStars(2);
       
       $this->setScore([
           "1" => 0,
           "2" => 0,
           "3" => 0,
           "4" => 0,
           "5" => 0,
           "6" => 0,
           "7" => 0,
           "8" => 0,
           "9" => 0,
           "10" => 0,
           "11" => 0,
           "12" => 0,
           "13" => 0
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
     * Set minStars
     *
     * @param integer $minStars
     *
     * @return Euromillions
     */
    public function setMinStars($minStars)
    {
        $this->minStars = $minStars;

        return $this;
    }

    /**
     * Get minStars
     *
     * @return int
     */
    public function getMinStars()
    {
        return $this->minStars;
    }

    /**
     * Set maxStars
     *
     * @param integer $maxStars
     *
     * @return Euromillions
     */
    public function setMaxStars($maxStars)
    {
        $this->maxStars = $maxStars;

        return $this;
    }

    /**
     * Get maxStars
     *
     * @return int
     */
    public function getMaxStars()
    {
        return $this->maxStars;
    }

    /**
     * Set countDrawStars
     *
     * @param integer $countDrawStars
     *
     * @return Euromillions
     */
    public function setCountDrawStars($countDrawStars)
    {
        $this->countDrawStars = $countDrawStars;

        return $this;
    }

    /**
     * Get countDrawStars
     *
     * @return int
     */
    public function getCountDrawStars()
    {
        return $this->countDrawStars;
    }

    /**
     * Set drawStars
     *
     * @param array $drawStars
     *
     * @return Euromillions
     */
    public function setDrawStars($drawStars)
    {
        $this->drawStars = $drawStars;

        return $this;
    }

    /**
     * Get drawStars
     *
     * @return array
     */
    public function getDrawStars()
    {
        return $this->drawStars;
    }

    /**
     * Set uStars
     *
     * @param array $uStars
     *
     * @return Euromillions
     */
    public function setUStars($uStars)
    {
        $this->uStars = $uStars;

        return $this;
    }

    /**
     * Get uStars
     *
     * @return array
     */
    public function getUStars()
    {
        return $this->uStars;
    }

    /**
     * Set goodStars
     *
     * @param array $goodStars
     *
     * @return Euromillions
     */
    public function setGoodStars($goodStars)
    {
        $this->goodStars = $goodStars;

        return $this;
    }

    /**
     * Get goodStars
     *
     * @return array
     */
    public function getGoodStars()
    {
        return $this->goodStars;
    }
}

