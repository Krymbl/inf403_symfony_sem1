<?php

declare(strict_types=1);
namespace App\Form;

use App\Dto\UserRegistrationDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Почта',
                'attr' => [
                    'maxlength' => 150,
                    'class' => 'email-input',
                    'placeholder' => 'example@gmail.com',
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Пароли не совпадают',
                'first_options' => ['label' => 'Пароль'],
                'second_options' => ['label' => 'Повторить пароль'],
                'options' => [
                    'attr' => [
                        'minlength' => 8,
                        'maxlength' => 100,
                        'class' => 'password-input',
                        'placeholder' => 'Введите пароль'
                    ],
                ],
            ])
            ->add('name', TextType::class, [
                'label' => 'Имя',
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 30,
                    'class' => 'name-input',
                    'placeholder' => 'Введите имя',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserRegistrationDto::class,
            'attr' => [
                'class' => 'user-registration-form',
            ],
        ]);
    }
}
