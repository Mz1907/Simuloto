<?php

namespace SimulotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SimulotoBundle\Entity\LotoFrSimulation;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

/**
 * Description of LotoFrFormSimulation
 *
 * @author Admin
 */
class LotoFrSimulationFormController extends Controller
{
     public function LotoFrSimulationFormAction()
    {
        $ltfr = new LotoFrSimulation();

        $data = [];

        $formBuilder = $this->createFormBuilder($data);

        /** building Euromillions BALLS grid with checkboxes * */
        for ($i = 1; $i <= ($ltfr->getMaxNb() + $ltfr->getMaxChance()); $i++)
        {
            if($i <= 49)
            {
                $class = 'ballsCheckBox';
            }
            elseif($i >= 50 && $i <= 60)
            {
                $class = 'chanceCheckBox';
            }

            $formBuilder->add($i, CheckboxType::class, [
                'label' => $i,
                'required' => false,
                'attr' => [
                    'class' => $class,
                    'data-toggle' => 'toggle',
                    'data-style' => 'ios',
                    'data-onstyle' => 'danger',
                    'data-offstyle' => 'info',
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

        return $this->render("SimulotoBundle:LotoFr:content.html.twig", [
                    "form" => $form->createview(),
        ]);
    }
}
