<?php

namespace CmsBundle\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController;

class ConfigAdminController extends CRUDController
{
    public function listAction()
    {
        return $this->redirectToConfig();
    }

    private function redirectToConfig()
    {
        return $this->redirect($this->generateUrl('admin_cms_config_edit', ['id' => 1]));
    }

    public function createAction()
    {
        return $this->redirectToConfig();
    }

    public function deleteAction($id)
    {
        return $this->redirectToConfig();
    }

    public function editAction($id = null)
    {
        if ($id != 1) {
            return $this->redirectToConfig();
        }

        return parent::editAction($id = null);
    }
}
