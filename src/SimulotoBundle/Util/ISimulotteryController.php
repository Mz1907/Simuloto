<?php

namespace SimulotoBundle\Util;

use Doctrine\ORM\Mapping as ORM;
/**
 * Implemented by all Lottery controllers
 */
Interface ISimulotteryController
{

    public function resultAction();
    
    public function buildScoreAction();
    
}
