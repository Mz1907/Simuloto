<?php

//function isBallPresent($ball, array $balls)
//{
//    return in_array(intval($ball), $balls);
//}
//
//function goodBalls(array $uNumbers, array $draw)
//{
//    $arrGoodBalls = [
//        "countGoodBalls" => 0, // show many good balls
//        "goodBallsList" => [] // list of the balls matched by uNumbers
//    ];
//
//    foreach ($uNumbers as $uNb)
//    {
//        if (is_numeric($uNb) && isBallPresent($uNb, $draw) === true)
//        {
//            $arrGoodBalls["countGoodBalls"] += 1;
//
//            array_push($arrGoodBalls["goodBallsList"], $uNb);
//        }
//    }
//
//    return $arrGoodBalls;
//}
//unitary tests
//$resultat1 = goodBalls([1, 2, 3], [1, 2, 3]);
//
//$resultat2 = goodBalls([1, 2, 3], [11, 22, 33]);
//
//$resultat3 = goodBalls([1, 2, 3], ["a", "d", "d"]);
//
//$resultat4 = goodBalls(["a", "d", "z"], [11, 22, 33]);
//
//$resultat5 = goodBalls([1, 2, 3], [11, 22, 33]);
//echo (($resultat1["countGoodBalls"] == 3) && is_array($resultat1["goodBallsList"]));
//echo (($resultat2["countGoodBalls"] == 0) && is_array($resultat1["goodBallsList"]));
//echo (($resultat2["countGoodBalls"] == 0) && is_array($resultat1["goodBallsList"]));
//echo (($resultat2["countGoodBalls"] == 0) && is_array($resultat1["goodBallsList"]));
//function checkBalls(array $arrBalls)
//{
//    $arrTemp = [];
//
//    foreach ($arrBalls as $ball)
//    {
//        if (!is_numeric($ball) || in_array($ball, $arrTemp))
//        {
//            return false;
//            
//        } else
//        {
//            $arrTemp[] = $ball;
//        }
//    }
//
//    return true;
//}
//
//echo "Résultat = ". (checkBalls([["e"], 4]) === false)."<br>";
//echo "Résultat = ". (checkBalls(["a", 4]) === false)."<br>";
//echo "Résultat = ". (checkBalls(["a", "j"]) === false)."<br>";
//echo "Résultat = ". (checkBalls([1, 2]) === true)."<br>";
//echo "Résultat = ". (checkBalls([1, 2]) === true)."<br>";
//echo "Résultat = ". (checkBalls([1, 2]) === true)."<br>";
//echo "Résultat = ". (checkBalls([1, 1]) === false)."<br>";
//echo "Résultat = ". (checkBalls([1, 2, 3]) === true)."<br>";
//echo "Résultat = ". (checkBalls([1, 2, 3, true]) === false)."<br>";
//echo "Résultat = ". (checkBalls([1, 2, null]) === false)."<br>";
//echo "Résultat = ". (checkBalls([1, 2, [5]]) === false)."<br>";
//echo "Résultat = ". (checkBalls([1, 2, array(9)]) === false)."<br>";
//echo "Résultat = ". (checkBalls([3, 2, 1]) === true)."<br>";
//
//

//function draw()
//{
//    $drawTemp = [];
//
//    do
//    {
//        $tempNb = mt_rand(1, 6);
//        if (!in_array($tempNb, $drawTemp))
//        {
//            $drawTemp[] = $tempNb;
//        }
//    } while (count($drawTemp) < 6);
//    
//    print_r($drawTemp);
//}
//
//draw();




