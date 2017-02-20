<?php
/**
 * Created by PhpStorm.
 * User: DarkRadish
 * Date: 20/01/2017
 * Time: 11:15
 */

namespace Ticketing\TicketingBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ticketing\TicketingBundle\Form\indexType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;


class TestController extends Controller
{
    public function testFormulaireAction(){

        $form = $this->createForm(new indexType());

        return $this->render('TicketingBundle:Default:test.html.twig', array('form'=> $form->createView()));

       /* $name = $email = $objet = "";

        $form = $this->createFormBuilder()
        ->add('name')
        ->add('email')
        ->add('objet', ChoiceType::class, array('choices' => array('In Stock' => "yes", 'Out of Stock' => "no")))
        ->add('send',SubmitType::class , array('label'=> 'ok'))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()){

            $name = $form["name"]->getData();
            $email = $form["email"]->getData();
            $objet = $form["objet"]->getData();
        }

        return $this->render('TicketingBundle:Default:test.html.twig', array('form'=> $form->createView(),
                                                                              'name'=> $name,
                                                                             'email'=> $email,'objet'=> $objet));*/

    }
}