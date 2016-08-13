<?php

namespace SimulotoBundle\Util;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Request;


/**
 * Implemented by all Lottery controllers
 */
Interface ISimulotteryController
{
    /** main methode when user push "play" button **/
    public function mainPlayAction(Request $request);

    public function buildScoreAction($loterrySimulationObject);
}
