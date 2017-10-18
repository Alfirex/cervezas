<?php

namespace cerveceriaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('cerveceriaBundle:Default:index.html.twig');
    }
}
