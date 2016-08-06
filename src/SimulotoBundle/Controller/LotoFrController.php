<?php

namespace SimulotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SimulotoBundle\Entity\LotoFrSimulation;
use SimulotoBundle\Util\ISimulotteryController;
use SimulotoBundle\Util\TraitSimulottery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of LotoFrController
 *
 * @author Admin
 */
class LotoFrController extends Controller implements ISimulotteryController
{
    use TraitSimulottery;

    /**
     * Main method of an Euromillions simulation
     *
     * @return JsonResponse for ajax request     *
     */
    public function mainPlayAction()
    {
        //Retrieve $countGames and uNemrs value from Request Object !
        $request = Request::createFromGlobals();

        $uNumbers = $request->request->get('uNumbers');
        $uChance = $request->request->get('uChance');
        $countGames = $request->request->get('countGames');

        $validation = $this->isContentValid($uNumbers, $uChance, $countGames);

        $isValid = $validation['isValide'];

        $response = [
            'uNumbers' => $uNumbers,
            'uChance' => $uChance,
            'countGames' => $countGames,
            'code' => 100,
            'success' => true,
            'isValid' => $isValid,
            'message' => $validation['message']
        ];

        if ($isValid)
        {

            $ltfr = new LotoFrSimulation();

            //good balls for html table "show all draw"
            $arrSimulationDetails = [
                'draw' => [],
                'drawChance' => [],
                'uNumbers' => [],
                'uChance' => [],
                'goodBalls' => [],
                'goodChance' => [],
                'message' => $validation['message']
            ];

            //hydrate EuromillionsSimulation
            $ltfr->setUNumbers($uNumbers);
            $ltfr->setUChance($uChance);
            $ltfr->setCountGames($countGames);

            /** calcul result of the simulation (controller is using trait methods) * */
            for ($i = 0; $i < $countGames; $i++)
            {

                $draw = $this->drawBalls($ltfr->getMinNb(), $ltfr->getMaxNb(), $ltfr->getCountDraw());
                $drawChance = $this->drawBalls($ltfr->getMinChance(), $ltfr->getMaxChance(), $ltfr->getCountDrawChance());

                $ltfr->setDraw($draw);
                $ltfr->setDrawChance($drawChance);

                $countUserGrids = count($uNumbers);

                $goodBalls = $this->goodBalls($uNumbers, $ltfr->getDraw());
                $ltfr->setGoodBalls($goodBalls);

                $goodChance = $this->goodBalls($uChance, $ltfr->getDrawChance());
                $ltfr->setGoodChance($goodChance);

                $score = $this->buildScoreAction($eur);

                $ltfr->setScore($score);

                array_push($arrSimulationDetails['draw'], $ltfr->getDraw());
                array_push($arrSimulationDetails['drawChance'], $ltfr->getDrawChance());
                array_push($arrSimulationDetails['uNumbers'], $ltfr->getUNumbers());
                array_push($arrSimulationDetails['uChance'], $ltfr->getUChance());
                array_push($arrSimulationDetails['goodBalls'], $goodBalls['goodBallsList']);
                array_push($arrSimulationDetails['goodChance'], $goodChance['goodBallsList']);
            }

            $response = [
                "validation" => $validation,
                "uNumbers" => $uNumbers,
                "uChance" => $uChance,
                "countGames" => $countGames,
                "code" => 100,
                "success" => true,
                'score' => $ltfr->getScore(),
                'arrSimulationDetails' => $arrSimulationDetails,
            ];
        }

        return new JsonResponse($response);
    }

    /**
     * @param $eur Euromillionssimulation object
     *
     * @return array
     */
    public function buildScoreAction($eur)
    {
        $goodBalls = $ltfr->getGoodBalls();
        $goodBalls = $goodBalls['countGoodBalls'];

        $goodChance = $ltfr->getGoodChance();
        $goodChance = $goodChance['countGoodBalls'];

        $score = $ltfr->getScore();

        if ($goodChance == 0)
        {
            switch ($goodBalls)
            {
                case 5: $score['3'] ++;
                    break;
                case 4: $score['6'] ++;
                    break;
                case 3: $score['10'] ++;
                    break;
                case 2: $score['13'] ++;
                    break;
            }
            return $score;
        } elseif ($goodChance == 1)
        {
            switch ($goodBalls)
            {
                case 5: $score['2'] ++;
                    break;
                case 4: $score['5'] ++;
                    break;
                case 3: $score['9'] ++;
                    break;
                case 2: $score['12'] ++;
                    break;
            }
            return $score;
        } elseif ($goodChance == 2)
        {
            switch ($goodBalls)
            {
                case 5: $score['1'] ++;
                    break;
                case 4: $score['4'] ++;
                    break;
                case 3: $score['7'] ++;
                    break;
                case 2: $score['8'] ++;
                    break;
                case 1: $score['11'] ++;
                    break;
            }
            return $score;
        }

        return false;
    }

    /**
     * check if ajax data format is correct: $arrUNumbers must be an array into an array containing digits
     * and each array must have a size between 6 and 10 [ [3, 15, 23, 27, 34, 45], [9, 14, 44, 23, 11, 30], ... ]
     * and $countGames must be a digit
     *
     * @return array
     * * */
    public function isContentValid(array $arrUNumbers, array $arrUChance, $countGames)
    {

        $validation = [
            'isValide' => false,
            'message' => 'none'
        ];

        if (is_numeric($countGames) && $countGames > 0)
        {
            if ($countGames !== "1" && $countGames !== "10" && $countGames !== "100" && $countGames !== "1000")
            {
                $validation['message'] = 'Erreur veuillez recommencer Error 1';
                $validation['countGame'] = $countGames;
                return $validation;
            }
        } else
        {
            $validation['message'] = 'Erreur veuillez recommencer. Error 2';
            return $validation;
        }

        /**
         * exemple of $arrUNumbers
         *
         * [ [11, 33, 12, 31, 29, 44], [3, 19, 45, 38, 27, 10], etc . . . ]
         */
        if (is_array($arrUNumbers) && count($arrUNumbers) > 4 && count($arrUNumbers) <= 10)
        {
            foreach ($arrUNumbers as $number)
            {
                if (is_numeric($number))
                {


                    if ($number >= 1 && $number <= 49)
                    {
                        $size = count($number);


                        if (!is_numeric($number))
                        {
                            $validation['message'] = 'Erreur veuillez recommencer. Error 3';
                            $validation['debug'] = $number;
                            return $validation;
                        }
                    } else
                    {
                        $validation['message'] = 'Erreur veuillez recommencer. Error 4';
                        return $validation;
                    }
                } else
                {
                    $validation['message'] = 'Error 5';
                    return $validation;
                }
            }
        } else
        {
            $validation['message'] = 'Erreur: Vous devez selectionner minimum 5 chiffres et maximum 10 chiffres. Error 6';
            return $validation;
        }
        /**
         * exemple of $arrUChance
         *
         * [1, 2, 3, 4]
         */
        $sizeArrChance = count($arrUChance);

        if ($sizeArrChance > 1 && $sizeArrChance <= 10)
        {

            for ($i = 0; $i < $sizeArrChance; $i++)
            {
                if (!is_numeric($arrUChance[$i]))
                {
                    $validation['message'] = 'Error 7';
                    return $validation;
                }
            }
        } else
        {
            $validation['message'] = 'Vous devez selectionner minimum 1 &eacute;toile et maximum 11 &eacute;toiles. Error 8';
            return $validation;
        }

        $validation['isValide'] = true;
        return $validation;
    }
}
