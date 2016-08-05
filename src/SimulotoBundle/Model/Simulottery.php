<?php

namespace SimulotoBundle\Model;

/**
 * Simulottery
 */
class Simulottery
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $countGames;

    /**
     * @var int
     */
    private $minNb;

    /**
     * @var int
     */
    private $maxNb;

    /**
     * @var int
     */
    private $countDraw;

    /**
     * @var array
     */
    private $draw;

    /**
     * @var array
     */
    private $uNumbers;

    /**
     * @var array
     */
    private $goodBalls;

    /**
     * @var array
     */
    private $score;


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
     * Set countGames
     *
     * @param integer $countGames
     *
     * @return Simulottery
     */
    public function setCountGames($countGames)
    {
        $this->countGames = intval($countGames);

        return $this;
    }

    /**
     * Get countGames
     *
     * @return int
     */
    public function getCountGames()
    {
        return $this->countGames;
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
     * Set countDraw
     *
     * @param integer $countDraw
     *
     * @return Simulottery
     */
    public function setCountDraw($countDraw)
    {
        $this->countDraw = $countDraw;

        return $this;
    }

    /**
     * Get countDraw
     *
     * @return int
     */
    public function getCountDraw()
    {
        return $this->countDraw;
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
     * Set goodBalls
     *
     * @param array $goodBalls
     *
     * @return Simulottery
     */
    public function setGoodBalls($goodBalls)
    {
        $this->goodBalls = $goodBalls;

        return $this;
    }

    /**
     * Get goodBalls
     *
     * @return array
     */
    public function getGoodBalls()
    {
        return $this->goodBalls;
    }

    /**
     * Set score
     *
     * @param array $score
     *
     * @return Simulottery
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return array
     */
    public function getScore()
    {
        return $this->score;
    }
}

