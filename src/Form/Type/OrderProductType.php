<?php

namespace App\Form\Type;

use App\Model\OrderProductModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $buider, array $options)
    {
        $buider
            ->add('id', IntegerType::class)
            ->add('quantity', IntegerType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderProductModel::class,
            'csrf_protection' => false
        ]);
    }
}