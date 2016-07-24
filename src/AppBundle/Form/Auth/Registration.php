<?php

namespace AppBundle\Form\Auth;


use AppBundle\Form\Form;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class Registration implements Form
{

    /**
     * {@inheritdoc}
     */
    public function build(FormBuilder $builder)
    {
        $builder->add('email', EmailType::class)
            ->add('username')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm Password'],
                'invalid_message' => 'Password Mismatch',]
            );

        return $builder->getForm();
    }
}