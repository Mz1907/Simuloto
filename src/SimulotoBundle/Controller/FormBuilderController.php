<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SimulotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SimulotoBundle\Entity\LottoSimulation;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Description of FormBuilderController
 *
 * @author Admin
 */
class FormBuilderController extends Controller
{

    public function LottoSimulationFormAction()
    {
        $lt = new LottoSimulation();

        $data = [];

        $formBuilder = $this->createFormBuilder($data);
        
        /** building Lotto grid with checkboxes * */
        for ($i = 1; $i <= $lt->getMaxNb(); $i++)
        {
            $formBuilder->add($i, CheckboxType::class, [
                'label' => $i,
                'required' => false,
                'attr' => [
                    'class' => 'ballsCheckBox'
                ]
            ]);
        }
        
        /** adding submit button **/
        $formBuilder->add('Envoyer', SubmitType::class, [
            'attr' => [
                'class' => 'save'
                ]
            ]);
        
        $form = $formBuilder->getForm();

        return $this->render("SimulotoBundle:Lotto:lotto.html.twig", [
            "form" => $form->createview()
                ]);
    }
}
