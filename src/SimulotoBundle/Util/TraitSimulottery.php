<?php

namespace SimulotoBundle\Util;

trait TraitSimulottery
{

    /**
     * drawBalls build a Lotto draw between minNb and maxNb
     * 
     * @return array
     */
    public function drawBalls($minNb, $maxNb, $countNb)
    {
        $draw = [];
        
        $i = 0;

        do
        {
            $tempNb = mt_rand($minNb, $maxNb);
            if (!in_array($tempNb, $draw))
            {
                $i++;
                
                $draw[$i] = $tempNb;
            }
        } while (count($draw) < $countNb);
        
        return $draw;
    }

    /**
     * Good Balls count how many good balls fro a draw a uNumbers has found
     * 
     * @param array $draw
     * @param array $uNumbers are $uNumbers who Matched
     * 
     * @return array
     */
    public function goodBalls(array $uNumbers, array $draw)
    {
        $arrGoodBalls = [
            "countGoodBalls" => 0, // show many good balls
            "goodBallsList" => [] // list of the balls matched by uNumbers
        ];

        foreach ($uNumbers as $key => $uNb)
        {
            if (in_array($uNb, $draw))
            {
                $arrGoodBalls["countGoodBalls"] += 1;

                array_push($arrGoodBalls["goodBallsList"], $uNb);
            }
        }

        return $arrGoodBalls;
    }

}
