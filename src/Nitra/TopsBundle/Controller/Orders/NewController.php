<?php

namespace Nitra\TopsBundle\Controller\Orders;

use Nitra\TopsBundle\Entity\Buyer;
use JMS\DiExtraBundle\Annotation as DI;
use Nitra\TopsBundle\Form\Type\Orders\NewType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\Form;
use Admingenerated\NitraTopsBundle\BaseOrdersController\NewController as BaseNewController;

/**
 * NewController
 */
class NewController extends BaseNewController
{

    /** @DI\Inject("doctrine.orm.entity_manager") */
    private $em;

    /**
     * @return Nitra\TopsBundle\Form\Type\Orders\NewType
     */
    protected function getNewType()
    {
        $type = new NewType($this->em);
        $type->setSecurityContext($this->get('security.context'));

        return $type;
    }

    /**
     * preBindRequest
     * @param \Nitra\OrderBundle\Entity\Order $Order your \Nitra\OrderBundle\Entity\Order object
     */

    /**
     * preBindRequest
     * @param \Nitra\OrderBundle\Entity\Order $Order your \Nitra\OrderBundle\Entity\Order object
     */
    public function preBindRequest(\Nitra\TopsBundle\Entity\Orders $Orders)
    {
        // получить тип формы
        $formType = $this->getNewType();

        // получть данные формы 
        $formData = $this->getRequest()->get($formType->getName());

        // получить пользователя 
        $buyer = $this->em->getRepository('NitraTopsBundle:Buyer')->find($formData['buyer_name']['id']);


        // Если пользователь не найден
        if (!$buyer) {
            // покупатель не найден создать нового 
            $buyer = new Buyer();
            $buyer->setName($formData['buyer_name']['name']);
            $buyer->setAddress($formData['address']);
            $buyer->setPhone($formData['buyer_phone']['name']);
            $this->em->persist($buyer);
        }
        $totalCost = 0;
        $totalCost = + $formData["deliveryCost"];
        foreach ($formData["orderEntry"] as $oe) {
            $totalCost +=  ($oe['assemblyCost'] + $oe['price']) * $oe['quantity'];
        }
        $Orders->setTotal($totalCost);

        $Orders->setStatus('Новый');
        // добавить покупателья в заказ
        $Orders->setBuyer($buyer);
    }

    /**
     * preSave
     * @param \Symfony\Component\Form\Form $form the valid form
     * @param \Nitra\OrderBundle\Entity\Order $Order your \Nitra\OrderBundle\Entity\Order object
     */
    public function preSave(\Symfony\Component\Form\Form $form, \Nitra\TopsBundle\Entity\Orders $Orders)
    {
        foreach ($Orders->getOrderEntry() as $orderEntry) {
            // проверить если новая позиция для заказа
            if (!$this->em->contains($orderEntry)) {
                // persist $orderEntry
                $orderEntry->setStatus('new');
                $orderEntry->setOrder($Orders);
                $this->em->persist($orderEntry);
            }
        }
    }

}
