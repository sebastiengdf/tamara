<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;

class ConfigAdmin extends \CoreBundle\Admin\ConfigAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);
    }
}