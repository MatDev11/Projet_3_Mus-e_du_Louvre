<?php

namespace Pages\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PagesController extends Controller
{
    public function cGVAction()
    {
        return $this->render('PagesBundle:Pages:CGV.html.twig');
    }

    public function mentionLegalesAction()
    {
        return $this->render('PagesBundle:Pages:MentionLegales.html.twig');
    }

    public function tarifAction()
    {
        return $this->render('PagesBundle:Pages:Tarif.html.twig');
    }
}
