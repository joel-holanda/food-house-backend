<?php

namespace App\Form\Type;

use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class StoreType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('name', TextType::class)
      ->add('description', TextType::class)
      ->add('cnpj', IntegerType::class)
      ->add('email', TextType::class);
  }
}
