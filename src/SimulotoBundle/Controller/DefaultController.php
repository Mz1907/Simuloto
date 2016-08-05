<?php

namespace SimulotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function showAboutAction()
    {
        return $this->render('SimulotoBundle:default:about.html.twig');
    }

    public function isContentValid(array $arrUNumbers, array $arrUStars, $countGames)
    {

        $validation = [
            'isValide' => false
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


                    if ($number >= 1 && $number <= 50)
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
         * exemple of $arrUStars
         * 
         * [1, 2, 3, 4]
         */
        $sizeArrStars = count($arrUStars);

        if ($sizeArrStars > 1 && $sizeArrStars <= 11)
        {

            for ($i = 0; $i < $sizeArrStars; $i++)
            {
                if (!is_numeric($arrUStars[$i]))
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

    public function testValidAction()
    {

        $arrAllTests = [];

        $test1 = $this->isContentValid([1, 2, 3, 4, 5, 6], [1, 2], "1");
        $test2 = $this->isContentValid([1, 2, 3, 4, 5, 6, 7, 8, 9, 10], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11], "1");
        $test3 = $this->isContentValid([1, 2, 3, 4, 5, 6], [1], "1");
        $test4 = $this->isContentValid([1, 2, 3, 4, 5, 6], [1, 2], "a");
        $test5 = $this->isContentValid([1, 2, 3, 4, 5], [1, 2], [1]);
        $test6 = $this->isContentValid([1, 2, 3, 4, 5, 6], [1, 2, "a"], "1");
        $test7 = $this->isContentValid([1, 2, 3, 4, 5, 6, "a"], [1, 2], "1");
        $test8 = $this->isContentValid([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11], [1, 2], "1");
        $test9 = $this->isContentValid([1, 2, 3, 4, 5, 6], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], "1");
        $test10 = $this->isContentValid([1, 2, 3, 4, 5, true], [1, 2], "1");
        $test11 = $this->isContentValid([1, 2, 3, 4, 5, 6], [1, true], "1");
        $test11 = $this->isContentValid([1, 2, 3, 4, 5, 6], [1, 2, 3, 4, 5, 6, 7, 7, 8, 9, 4, 3], "1");

        $arrAllTests[] = $test1['isValide'] === true;
        $arrAllTests[] = $test2['isValide'] === true;

        $arrAllTests[] = $test3['isValide'] === false;
        $arrAllTests[] = $test4['isValide'] === false;
        $arrAllTests[] = $test5['isValide'] === false;
        $arrAllTests[] = $test6['isValide'] === false;
        $arrAllTests[] = $test7['isValide'] === false;
        $arrAllTests[] = $test8['isValide'] === false;
        $arrAllTests[] = $test9['isValide'] === false;
        $arrAllTests[] = $test10['isValide'] === false;
        $arrAllTests[] = $test11['isValide'] === false;

        return $this->render('SimulotoBundle:Default:test.html.twig', [
                    'test' => $arrAllTests,
                    'debug' => $test8
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////////////////////

    public function buildScoreAction($goodBalls, $goodStars)
    {

        $score = [
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
        ];

        if ($goodStars == 0)
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
        } elseif ($goodStars == 1)
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
        } elseif ($goodStars == 2)
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

    ////////////////////////////////////////////////////////
    public function testBuildScoreAction()
    {
        $result = [];

        $score = $this->buildScoreAction(5, 2);
        $result["test1"] = $score['1'] == 1;

        $score = $this->buildScoreAction(5, 1);
        $result["test2"] = $score['2'] == 1;

        $score = $this->buildScoreAction(5, 0);
        $result["test3"] = $score['3'] == 1;

        $score = $this->buildScoreAction(4, 2);
        $result["test4"] = $score['4'] == 1;

        $score = $this->buildScoreAction(4, 1);
        $result["test5"] = $score['5'] == 1;
        
        $score = $this->buildScoreAction(4, 0);
        $result["test6"] = $score['6'] == 1;
        
        $score = $this->buildScoreAction(3, 2);
        $result["test7"] = $score['7'] == 1;
        
        $score = $this->buildScoreAction(3, 1);
        $result["test8"] = $score['9'] == 1;
        
        $score = $this->buildScoreAction(3, 0);
        $result["test9"] = $score['10'] == 1;
        
        $score = $this->buildScoreAction(2, 2);
        $result["test10"] = $score['8'] == 1;
        
        $score = $this->buildScoreAction(1, 2);
        $result["test11"] = $score['11'] == 1;
        
        $score = $this->buildScoreAction(2, "1");
        $result["test12"] = $score['12'] == false;
        
        $score = $this->buildScoreAction(2, true);
        $result["test13"] = $score['13'] == false;

        $score = $this->buildScoreAction(2, [0]);
        $result["test13"] = $score['13'] == false;
        
       return $this->render('SimulotoBundle:default:test.html.twig', [
                    'result' => $result
        ]);
    }

}
