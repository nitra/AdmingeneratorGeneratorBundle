<?php

namespace Nitra\TopsBundle\Controller\OrderEntry;

use Admingenerated\NitraTopsBundle\BaseOrderEntryController\EditController as BaseEditController;

/**
 * EditController
 */
class EditController extends BaseEditController
{

    /**
     *  Загрузка изображений
     *
     */
    public function preBindRequest(\Nitra\TopsBundle\Entity\OrderEntry $OrderEntry)
    {
        $file = $this->getRequest()->get('file');
        $OrderEntry->setFile($file);
    }

}
