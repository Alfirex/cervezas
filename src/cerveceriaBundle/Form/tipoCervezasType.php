<?php

namespace cerveceriaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class tipoCervezasType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre')
                ->add('pais')
                ->add('poblacion')
                ->add('tipo')
                ->add('importacion')
                ->add('tamano')
                ->add('fechaAlmacen')
                ->add('cantidad')
                ->add('foto')
                ->add($options['boton_submit'],SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'cerveceriaBundle\Entity\tipoCervezas',
            'boton_submit' => 'Enviar'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'cerveceriabundle_tipocervezas';
    }


}
