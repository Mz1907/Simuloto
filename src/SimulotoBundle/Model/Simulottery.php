<?php

namespace SimulotoBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 *
 */
abstract class Simulottery
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    protected $name;

    /**
     * @var int
     *
     * @ORM\Column(name="minNb", type="smallint")
     */
    protected $minNb;

    /**
     * @var int
     *
     * @ORM\Column(name="maxNb", type="smallint")
     */
    protected $maxNb;

    /**
     * @var array
     *
     * @ORM\Column(name="draw", type="array")
     */
    protected $draw;

    /**
     * @var array
     *
     * @ORM\Column(name="uNumbers", type="array")
     */
    protected $uNumbers;

    /**
     * @var int
     *
     * @ORM\Column(name="drawCount", type="integer")
     */
    protected $drawCount;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    protected $country;

    /**
     * @var array
     *
     * @ORM\Column(name="result", type="json_array")
     */
    protected $result;

    /**
     * Good Balls count how many good balls fro a draw a uNumbers has found
     * 
     * @param array $draw
     * @param array $uNumbers 
     * 
     * @return array
     */
    public function goodBalls(array $uNumbers, array $draw)
    {
        $arrGoodBalls = [
            "countGoodBalls" => 0, // show many good balls
            "goodBallsList" => [] // list of the balls matched by uNumbers
        ];

        foreach ($uNumbers as $uNb)
        {
            if ($this->isBallPresent($uNb, $draw) === true)
            {
                $arrGoodBalls["countGoodBalls"] += 1;

                array_push($arrGoodBalls["goodBallsList"], $uNb);
            }
        }

        return $arrGoodBalls;
    }

    /**
     * Is ball present check if a ball is present into an array of balls
     * @param integer $ball
     * @param array $balls
     * 
     * @return boolean
     */
    public function isBallPresent($ball, array $balls)
    {
        return in_array(intval($ball), $balls);
    }

    /**
     * Check Balls Check if there is 2 balls (or more) having the same value (this isn't allowed in the app)
     * @param array $arrBalls
     * 
     * @return boolean
     */
    public function checkBalls(array $arrBalls)
    {
        $arrTemp = [];

        foreach ($arrBalls as $ball)
        {
            if(in_array($ball, $arrTemp))
            {
                return false;
            } 
            else
            {
                $arrTemp[] = $ball;
            }
        }
        
        return true;
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
     * Set name
     *
     * @param string $name
     *
     * @return Simulottery
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set minNb
     *
     * @param integer $minNb
     *
     * @return Simulottery
     */
    public function setMinNb($minNb)
    {
        $this->minNb = $minNb;

        return $this;
    }

    /**
     * Get minNb
     *
     * @return int
     */
    public function getMinNb()
    {
        return $this->minNb;
    }

    /**
     * Set maxNb
     *
     * @param integer $maxNb
     *
     * @return Simulottery
     */
    public function setMaxNb($maxNb)
    {
        $this->maxNb = $maxNb;

        return $this;
    }

    /**
     * Get maxNb
     *
     * @return int
     */
    public function getMaxNb()
    {
        return $this->maxNb;
    }

    /**
     * Set draw
     *
     * @param array $draw
     *
     * @return Simulottery
     */
    public function setDraw($draw)
    {
        $this->draw = $draw;

        return $this;
    }

    /**
     * Get draw
     *
     * @return array
     */
    public function getDraw()
    {
        return $this->draw;
    }

    /**
     * Set uNumbers
     *
     * @param array $uNumbers
     *
     * @return Simulottery
     */
    public function setUNumbers($uNumbers)
    {
        $this->uNumbers = $uNumbers;

        return $this;
    }

    /**
     * Get uNumbers
     *
     * @return array
     */
    public function getUNumbers()
    {
        return $this->uNumbers;
    }

    /**
     * Set drawCount
     *
     * @param integer $drawCount
     *
     * @return Simulottery
     */
    public function setDrawCount($drawCount)
    {
        $this->drawCount = $drawCount;

        return $this;
    }

    /**
     * Get drawCount
     *
     * @return int
     */
    public function getDrawCount()
    {
        return $this->drawCount;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Simulottery
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set result
     *
     * @param array $result
     *
     * @return Simulottery
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }

}
