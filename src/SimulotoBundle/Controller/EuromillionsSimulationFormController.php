<?php

namespace SimulotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SimulotoBundle\Entity\EuromillionsSimulation;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Description of EuromillionsSimulationFormController
 *
 * @author Admin
 */
class EuromillionsSimulationFormController extends Controller
{

    public function EuromillionsSimulationFormAction()
    {
        $eur = new EuromillionsSimulation();

        $data = [];

        $formBuilder = $this->createFormBuilder($data);

        /** building Euromillions BALLS grid with checkboxes * */
        for ($i = 1; $i <= ($eur->getMaxNb() + $eur->getMaxStars()); $i++)
        {
            if($i <= 50)
            {
                $class = 'ballsCheckBox';
            }
            elseif($i >= 51 && $i <= 62)
            {
                $class = 'starsCheckBox';
            }

            $formBuilder->add($i, CheckboxType::class, [
                'label' => $i,
                'required' => false,
                'attr' => [
                    'class' => $class,
                    'data-toggle' => 'toggle',
                    'data-style' => 'ios',
                    'data-onstyle' => 'primary',
                    'data-offstyle' => 'warning',
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

        $form = $formBuilder->getForm();

        return $this->render("SimulotoBundle:Euromillions:content.html.twig", [
                    "form" => $form->createview(),
        ]);
    }

}