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
    public function mainPlayAction(Request $request)
    {
        $uNumbers = $request->get('uNumbers'); //return null
        $uChance = $request->get('uChance'); //return null
        $countGames = $request->get('countGames');

        $validation = $this->isContentValidAction($uNumbers, $uChance, $countGames);

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

                $score = $this->buildScoreAction($ltfr);

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
                'message' => $validation['message']
            ];
        }

        return $this->json($response);
    }

    /**
     * @param $ltfr Euromillionssimulation object
     *
     * @return array
     */
    public function buildScoreAction($ltfr)
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
                case 5: $score['2'] ++;
                    break;
                case 4: $score['3'] ++;
                    break;
                case 3: $score['4'] ++;
                    break;
                case 2: $score['5'] ++;
                    break;
            }
            return $score;
        } elseif ($goodChance == 1)
        {
            switch ($goodBalls)
            {
                case 5: $score['1'] ++;
                    break;
                case 4: $score['3'] ++;
                    break;
                case 3: $score['4'] ++;
                    break;
                case 2: $score['5'] ++;
                    break;
                default : $score['6'] ++;
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
    public function isContentValidAction(array $arrUNumbers, array $arrUChance, $countGames)
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
            $validation['message'] = 'Erreur: Vous devez selectionner minimum 5 chiffres et maximum 10 chiffres';
            return $validation;
        }
        /**
         * exemple of $arrUChance
         *
         * [1, 2, 3, 4]
         */
        $sizeArrChance = count($arrUChance);

        if ($sizeArrChance >= 1 && $sizeArrChance <= 10)
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
            $validation['message'] = 'Vous devez selectionner minimum 1 numéros chance et maximum 1';
            return $validation;
        }

        /** at this point datas are valids * */
        /** test if uBalls and uStars respect grid "multiple" patterns * */
        $ballsLength = count($arrUNumbers);
        $chanceLength = count($arrUChance);

        if ($ballsLength == 9)
        {
            if ($chanceLength == 1)
            {
                $validation['patternMultiple'] = true;
            }
        }
        if ($ballsLength == 8)
        {
            if ($chanceLength > 1 && $chanceLength <= 3)
            {
                $validation['patternMultiple'] = true;
            }
        }
        if ($ballsLength == 7)
        {
            if ($chanceLength >= 1 && $chanceLength <= 8)
            {
                $validation['patternMultiple'] = true;
            }
        }
        if ($ballsLength == 6 || $ballsLength == 5)
        {
            if ($chanceLength >= 1 && $chanceLength <= 10)
            {
                $validation['patternMultiple'] = true;
            }
        }
        if ($validation['patternMultiple'] !== true)
        {
            $validation['message'] = 'Vous devez entrer une grille multiple avec un nombre de numéros et d\'étoiles valides';
            $validation['patternMultiple'] = false;
            $validation['isValide'] = false;
        } else
        {
            $validation['isValide'] = true;
        }

        return $validation;
    }

}
