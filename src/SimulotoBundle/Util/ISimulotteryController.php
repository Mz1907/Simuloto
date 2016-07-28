<?php

namespace SimulotoBundle\Util;

use Doctrine\ORM\Mapping as ORM;

/**
 * Implemented by all Lottery controllers
 */
Interface ISimulotteryController
{
    /** main methode when user push "play" button **/
    public function playAction();


    public function buildScoreAction($loterrySimulationObject);
}
