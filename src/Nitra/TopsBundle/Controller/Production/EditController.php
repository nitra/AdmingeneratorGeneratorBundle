<?php

namespace Nitra\TopsBundle\Controller\Production;

use Admingenerated\NitraTopsBundle\BaseProductionController\EditController as BaseEditController;

/**
 * EditController
 */
class EditController extends BaseEditController
{

    /**
     *  Загрузка изображений
     *
     */
    public function preBindRequest(\Nitra\TopsBundle\Entity\Production $Production)
    {
        $file = $this->getRequest()->get('file');
        $Production->setFile($file);
    }

}
