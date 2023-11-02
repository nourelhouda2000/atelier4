<?php

namespace App\Form;

use App\Entity\Auther;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AutherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('email')
            ->add('save', SubmitType::class, [
                'label' => 'save',
                'attr' => ['class' => 'btn btn-success'], // Utilisez la classe 'btn-success' pour un bouton vert
            ])
            ->getForm()
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Auther::class,
        ]);
    }
}
