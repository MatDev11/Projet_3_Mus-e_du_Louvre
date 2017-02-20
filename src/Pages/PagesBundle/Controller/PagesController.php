<?php

namespace Pages\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PagesController extends Controller
{
    public function CGVAction()
    {
        return $this->render('PagesBundle:Pages:CGV.html.twig');
    }

    public function MentionLegalesAction()
    {
        return $this->render('PagesBundle:Pages:MentionLegales.html.twig');
    }
}
