<?php

namespace Nitra\TopsBundle\Controller\Income;

use Admingenerated\NitraTopsBundle\BaseIncomeController\NewController as BaseNewController;

class NewController extends BaseNewController
{

    /**
     * переопределяем создание формы 
     * Creates and returns a Form instance from the type of the form.
     * @param string|FormTypeInterface $type    The built type of the form
     * @param mixed                    $data    The initial data for the form
     * @param array                    $options Options for the form
     * @return Form
     */
    public function createForm($type, $data = null, array $options = array())
    {

        // получить объект пользователя
        $options['em'] = $this->getDoctrine()->getManager();


        // родитель создать форму
        return parent::createForm($type, $data, $options);
    }

}
