<?php

namespace cerveceriaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class cervezaController extends Controller
{
    public function allAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('cerveceriaBundle:tipoCervezas');
        // find *all* cervezas
        $cervezas = $repository->findById($id);
        return $this->render('cerveceriaBundle:CarpetaCerveza:all.html.twig',array('IdCerveza' => $cervezas ));
    }
}
