<?php

namespace CoreBundle\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController;

class ConfigAdminController extends CRUDController
{

    public function listAction()
    {
        return $this->redirect($this->generateUrl('admin_core_config_edit', ['id' => 1]));
    }

    public function createAction()
    {
        return $this->redirect($this->generateUrl('admin_core_config_edit', ['id' => 1]));
    }

    public function deleteAction($id)
    {
        return $this->redirect($this->generateUrl('admin_core_config_edit', ['id' => 1]));
    }

    public function editAction($id = null)
    {
        if($id != 1) {
            return $this->redirect($this->generateUrl('admin_core_config_edit', ['id' => 1]));
        }
        return parent::editAction($id = null);
    }

}
