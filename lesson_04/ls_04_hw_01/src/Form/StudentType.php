<?php

declare(strict_types=1);

namespace App\Form;

use App\Dto\StudentDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class StudentType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => 'ФИО',
                'attr' => [
                    'class' => 'fullName-input',
                    'placeholder' => 'Полное ФИО',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StudentDto::class,
            'attr' => [
                'class' => 'student-save-form',
            ],
        ]);
    }
}
