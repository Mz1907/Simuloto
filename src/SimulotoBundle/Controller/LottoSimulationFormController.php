<?php

namespace SimulotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SimulotoBundle\Entity\LottoSimulation;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

/**
 * Description of FormBuilderController
 *
 * @author Admin
 */
class LottoSimulationFormController extends Controller
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
                    'class' => 'ballsCheckBox',
                    'data-toggle' => 'toggle',
                    'data-style' => 'ios',
                    'data-onstyle' => 'warning',
                    'data-offstyle' => 'danger',
                    'value' => $i
                ]
            ]);
        }

        $formBuilder->add('Nombre_de_tirages', ChoiceType::class, [
            'choices' => [
                '1' => 1,
                '10' => 10,
                '100' => 100,
                '1000' => 1000,
            ],
            'attr' => [
                'class' => 'countGames input-sm input-small',
            ]
        ]);

        /** adding submit button * */
        $formBuilder->add('Simuler', SubmitType::class, [
            'attr' => [
                'class' => 'save btn btn-success'
            ]
        ]);
        
        /** adding button reset **/
        $formBuilder->add('Reset', ResetType::class, [
            'attr' => [
                'class' => 'btn btn-warning'
            ]
        ]);
        
        
        $form = $formBuilder->getForm();

        return $this->render("SimulotoBundle:Lotto:content.html.twig", [
                    "form" => $form->createview()
        ]);
    }

}
