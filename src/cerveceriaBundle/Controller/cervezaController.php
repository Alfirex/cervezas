<?php

namespace cerveceriaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use cerveceriaBundle\Entity\tipoCervezas;
use cerveceriaBundle\Form\tipoCervezasType;
use Symfony\Component\HttpFoundation\Request;

class cervezaController extends Controller
{
    public function mostrarCervezaAction()
    {
        $repository = $this->getDoctrine()->getRepository('cerveceriaBundle:tipoCervezas');
        $mostrar = $repository->findAll();
        return $this->render('cerveceriaBundle:CarpetaCerveza:mostrarCervezas.html.twig',array('TablaCervezas' => $mostrar ));
    }

    public function idAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('cerveceriaBundle:tipoCervezas');
        $mostrar = $repository->findById($id);
        return $this->render('cerveceriaBundle:CarpetaCerveza:id.html.twig',array('IdCerveza' => $mostrar ));
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
    public function insertarFormularioAction(Request $request)
    {
      $tipoCerveza = new tipoCervezas();
      $form= $this->createForm(tipoCervezasType::class,$tipoCerveza,array('boton_submit'=> "Insertar"));
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
                // $form->getData() holds the submitted values
                // but, the original `$task` variable has also been updated
                $tipoCerveza = $form->getData();

                // ... perform some action, such as saving the task to the database
                // for example, if Task is a Doctrine entity, save it!
                 $DB = $this->getDoctrine()->getManager();
                 $DB->persist($tipoCerveza);
                 $DB->flush();

                 $repository = $this->getDoctrine()->getRepository('cerveceriaBundle:tipoCervezas');
                 $id=$tipoCerveza->getId();
                 $mostrar = $repository->find($id);
                 return $this->render('cerveceriaBundle:CarpetaCerveza:ultimoInsertado.html.twig', array('TablaCervezas'=>$mostrar ) );
            }
        return $this->render('cerveceriaBundle:CarpetaCerveza:insertarFormulario.html.twig',array('form'=>$form->createView()));
    }

    public function actualizarFormularioAction(Request $request,$id)
    {
        $cerveza = $this->getDoctrine()->getRepository('cerveceriaBundle:tipoCervezas')->find($id);

        if(!$cerveza){return $this->redirectToRoute('cerveceria_mostrarCerveza');}
        $form = $this->createForm(\cerveceriaBundle\Form\tipoCervezasType::class, $cerveza,array('boton_submit'=> "Actualizar"));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $DB = $this->getDoctrine()->getManager();
            $DB->persist($cerveza);
            $DB->flush();
            return $this->redirectToRoute('cerveceria_ActualizarFormulario', ["id" => $id]);
        }
        return $this->render("cerveceriaBundle:CarpetaCerveza:modificarFormulario.html.twig", array('form'=>$form->createView() ));
    }
}
