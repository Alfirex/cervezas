<?php

namespace cerveceriaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use cerveceriaBundle\Entity\tipoCervezas;

class cervezaController extends Controller
{
    public function allAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('cerveceriaBundle:tipoCervezas');
        // find *all* cervezas
        $cervezas = $repository->findById($id);
        return $this->render('cerveceriaBundle:CarpetaCerveza:all.html.twig',array('IdCerveza' => $cervezas ));
    }

    public function crearCervezaAction($nombre,$pais)
    {
        //-- Nuevo objeto de tipoCerveza --\\
        $tipoCerveza = new tipoCervezas();
        $tipoCerveza->setNombre($nombre);
        $tipoCerveza->setPais($pais);
        $tipoCerveza->setPoblacion('Valencia');
        $tipoCerveza->setTipo('Valencia');
        $tipoCerveza->setImportacion(true);
        $tipoCerveza->setTamano(2);
        $tipoCerveza->setFechaAlmacen(\DateTime::createFromFormat("d/m/Y","24/12/2018"));
        $tipoCerveza->setCantidad(2);
        $tipoCerveza->setFoto('img/imagen.jpg');

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $mangDoct = $this->getDoctrine()->getManager();
        $mangDoct->persist($tipoCerveza);

        // actually executes the queries (i.e. the INSERT query)

        $flush = $mangDoct->flush($tipoCerveza);

        if ($flush == null) {
            echo "se ha creada correctamente";
        } else {
            echo "no se ha creado la Cerveza";
        }

        $repository = $this->getDoctrine()->getRepository('cerveceriaBundle:tipoCervezas');
        $id=$tipoCerveza->getId();
        $cervezas = $repository->findById($id);

        return $this->render('cerveceriaBundle:CarpetaCerveza:crearCerveza.html.twig',array('TablaCervezas'=>$cervezas ));
    }

    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('cerveceriaBundle:tipoCervezas')->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No existe con ese id '.$id
            );
        }

        $product->setNombre('Valencia un equipo de segunda');
        $em->flush();

        $repository = $this->getDoctrine()->getRepository('cerveceriaBundle:tipoCervezas');
        $cervezas = $repository->findById($id);

      return $this->render("cerveceriaBundle:CarpetaCerveza:update.html.twig", array('TablaCervezas'=>$cervezas ));
    }
}
