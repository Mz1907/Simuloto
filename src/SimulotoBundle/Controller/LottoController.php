<?php

namespace SimulotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SimulotoBundle\Util\ISimulotteryController;

class LottoController extends Controller implements ISimulotteryController
{
    public function resultAction()
    {
        return $this->render('SimulotoBundle:Lotto:result.html.twig', array(
            // ...
        ));
    }

    public function buildScoreAction()
    {
        return $this->render('SimulotoBundle:Default:index.html.twig', array(
            // ...
        ));
    }

}
