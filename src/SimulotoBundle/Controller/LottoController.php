<?php

namespace SimulotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SimulotoBundle\Entity\LottoSimulation;
use SimulotoBundle\Util\ISimulotteryController;
use SimulotoBundle\Util\TraitSimulottery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class LottoController extends Controller implements ISimulotteryController
{

    use TraitSimulottery;

    public function playAction()
    {
        //Retrieve $countGames and uNemrs value from Request Object ! 
        $request = Request::createFromGlobals();
        
        $uNumbers = $request->request->get('uNumbers');        
        $countGames = $request->request->get('countGames');

        $lt = new LottoSimulation();
        
        //hydrate LottoSimulation
        $lt->setUNumbers($uNumbers);
        for ($i = 0; $i < $countGames; $i++)
        {
            $lt->setDraw($this->drawBalls($lt->getMinNb(), $lt->getMaxNb(), $lt->getCountDraw()));

            $lt->setGoodBalls($this->goodBalls($lt->getUNumbers(), $lt->getDraw()));

            $lt->setHasComp($this->hasComp($lt));
            
            $lt->setScore($this->buildScoreAction($lt));
        }
        
        //create JsonResponse
        $response = array("lt" => $lt, "uNumbers" => $uNumbers, "countGames" => $countGames, "score" => $lt->getScore(), "code" => 100, "success" => true);
        
        return new JsonResponse($response);
    }

    public function hasComp(LottoSimulation $lt)
    {
        $goodBalls = $lt->getGoodBalls();
        
        $draw = $lt->getDraw();
        
        $comp = end($draw);

        return in_array($comp, $goodBalls["goodBallsList"]);
    }

    /** 
     * Main method of a new game 
     * $lt Object LotterySimulation Object ex: LottoSimulation, EuromillionSimulation
     * */
    public function buildScoreAction($lt)
    {
        $goodBalls = $lt->getGoodBalls();
        
        $score = $lt->getScore();

        if ($lt->getHasComp() === false)
        {
            switch ($goodBalls["countGoodBalls"])
            {
                case 6: $score["1"]++; break;
                case 5: $score["3"]++; break;
                case 4: $score["5"]++; break;
                case 3: $score["7"]++; break;
            }
        } elseif ($lt->getHasComp() === true)
        {
            switch ($goodBalls["countGoodBalls"])
            {
                case 5: $score["2"] ++; break;
                case 4: $score["4"] ++; break;
                case 3: $score["6"] ++; break;
                case 2: $score["8"] ++; break;
            }
        }
        
        return $score;
    }

}
