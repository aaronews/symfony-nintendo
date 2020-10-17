<?php

namespace App\Form\Search;

use App\Entity\Search\License;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LicenseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,array(
                'required' => false,
                'label' => 'licenses.form.name.label',
                'row_attr' => array(
                    'class' => 'col-sm-10'
                ),
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'form.button.filter',
                'row_attr' => array(
                    'class' => 'col-sm-2 text-center m-auto'
                ),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => License::class,
        ]);
    }

    public function getParent()
    {
        return AbstractSearchType::class;
    }
}
