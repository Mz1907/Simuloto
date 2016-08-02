<?php

namespace SimulotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SimulotoBundle\Entity\LottoSimulation;
use SimulotoBundle\Util\ISimulotteryController;
use SimulotoBundle\Util\TraitSimulottery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use SimulotoBundle\Controller\LottoValidationController;

class LottoController extends Controller implements ISimulotteryController
{

    use TraitSimulottery;
    
    
    /**
     * Main method of a lotto simulation
     * 
     * @return JsonResponse for ajax request     * 
     */
    public function mainPlayAction()
    {
        //Retrieve $countGames and uNemrs value from Request Object ! 
        $request = Request::createFromGlobals();

        $uNumbers = $request->request->get('uNumbers');
        $countGames = $request->request->get('countGames');

        $validation = $this->isContentValid($uNumbers, $countGames);

        if ($validation['isValide'])
        {
            $lt = new LottoSimulation();
            
            //good balls for html table "show all draw"
            $arrSimulatonDetails = [
                'draw' => [],
                'uNumbers' => [],
                'goodBalls' => []
            ];

            //hydrate LottoSimulation
            $lt->setUNumbers($uNumbers);

            /** calcul result of the simulation (controller is using trait methods) **/
            for ($i = 0; $i < $countGames; $i++)
            {

                $draw = $this->drawBalls($lt->getMinNb(), $lt->getMaxNb(), $lt->getCountDraw());
                $lt->setDraw($draw);

                $countUserGrids = count($uNumbers);

                for ($j = 0; $j < $countUserGrids; $j++)
                {   
                    $goodBalls = $this->goodBalls($uNumbers[$j], $lt->getDraw());
                    $lt->setGoodBalls($goodBalls);
                    
                    $hasComp = $this->hasComp($lt);
                    $lt->setHasComp($hasComp);
                    
                    $score = $this->buildScoreAction($lt);
                    $lt->setScore($score);
                    
                    array_push($arrSimulatonDetails['draw'], $draw);
                    array_push($arrSimulatonDetails['uNumbers'], $uNumbers[$j]);
                    array_push($arrSimulatonDetails['goodBalls'], $goodBalls['goodBallsList']);
                    
                }
            }

            //create JsonResponse
            $response = [
                'countGames' => $countGames,
                'arrSimulationDetails' => $arrSimulatonDetails, 
                'score' => $lt->getScore(),
                'code' => 100,
                'success' => true
            ];
        } else
        {
            $response = [
                'response' => 'non-valide',
                'validation' => $validation
            ];
        }
        
        
        return new JsonResponse($response);
    }
    
    /** 
     * 
     * check if current uNumbers match comp num 
     * 
     * @return array
     * **/
    public function hasComp(LottoSimulation $lt)
    {
        $goodBalls = $lt->getGoodBalls();

        $draw = $lt->getDraw();

        $comp = end($draw);

        return in_array($comp, $goodBalls['goodBallsList']);
    }

    /**
     * 
     * $lt Object LotterySimulation Object ex: LottoSimulation, EuromillionSimulation
     * 
     * @return array
     * */
    public function buildScoreAction($lt)
    {
        $goodBalls = $lt->getGoodBalls();

        $score = $lt->getScore();

        if ($lt->getHasComp() === false)
        {
            switch ($goodBalls['countGoodBalls'])
            {
                case 6: $score['1'] ++;
                    break;
                case 5: $score['3'] ++;
                    break;
                case 4: $score['5'] ++;
                    break;
                case 3: $score['7'] ++;
                    break;
            }
        } elseif ($lt->getHasComp() === true)
        {
            switch ($goodBalls['countGoodBalls'])
            {
                case 5: $score['2'] ++;
                    break;
                case 4: $score['4'] ++;
                    break;
                case 3: $score['6'] ++;
                    break;
                case 2: $score['8'] ++;
                    break;
            }
        }

        return $score;
    }
    
    /**
     * check if ajax data format is correct: $arrUNumbers must be an array into an array containing digits 
     * and each array must have a size between 6 and 10 [ [3, 15, 23, 27, 34, 45], [9, 14, 44, 23, 11, 30], ... ]
     * and $countGames must be a digit 
     * 
     * @return array
     * **/

    public function isContentValid(array $arrUNumbers, $countGames)
    {

        $validation = [
            'isValide' => false,
            'message' => ''
        ];

        $countGames = intval($countGames);
        if ($countGames !== 1 && $countGames !== 10 && $countGames !== 100 && $countGames !== 1000)
        {
            $validation['isValide'] = false;
            $validation['message'] = 'error countGames';
            $validation['countGame'] = $countGames;
            return $validation;
        }

        /**
         * exemple of $arrUNumbers
         * 
         * [ [11, 33, 12, 31, 29, 44], [3, 19, 45, 38, 27, 10], etc . . . ]
         */
        if (is_array($arrUNumbers) && count($arrUNumbers) > 0)
        {
            foreach ($arrUNumbers as $uNumbers)
            {
                if (is_array($uNumbers) && count($uNumbers) >= 6 && count($uNumbers) <= 10)
                {
                    $size = count($uNumbers);

                    for ($i = 0; $i < $size; $i++)
                    {
                        if (!is_numeric($uNumbers[$i]))
                        {
                            $validation['message'] = 'Error 3';
                            return $validation;
                        }
                    }
                } else
                {
                    $validation['message'] = 'Error 2';
                    return $validation;
                }
            }

            $validation['isValide'] = true;
            return $validation;
        } else
        {
            $validation['message'] = 'Error 1';
            return $validation;
        }
    }

}
