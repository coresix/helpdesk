<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilder;


interface Form
{

    /**
     * @param FormBuilder $builder
     * @return \Symfony\Component\Form\Form
     */
    public function build(FormBuilder $builder);
}