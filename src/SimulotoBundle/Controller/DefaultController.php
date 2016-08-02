<?php

namespace SimulotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function showAboutAction()
    {
        return $this->render('SimulotoBundle:default:about.html.twig');
    }

}
