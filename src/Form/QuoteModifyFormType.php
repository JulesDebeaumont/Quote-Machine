<?php

namespace App\Form;

use App\Entity\Quote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class QuoteModifyFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextType::class, [
                'label' => 'La quote :',
                ])

            ->add('meta', TextType::class, [
                'label' => 'La source :',
                ])

            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer !'
            ]);

            //->setMethod('POST') par défaut
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quote::class,
        ]);
    }
}
