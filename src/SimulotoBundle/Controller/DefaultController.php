<?php

namespace SimulotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SimulotoBundle:Default:index.html.twig');
    }
}
