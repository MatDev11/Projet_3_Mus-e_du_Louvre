<?php

namespace Pages\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function CVGAction()
    {
        return $this->render('PagesBundle:Default:CGV.html.twig');
    }
}
