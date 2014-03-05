<?php

namespace Nitra\TopsBundle\Controller\Orders;

use JMS\DiExtraBundle\Annotation as DI;
use Nitra\TopsBundle\Form\Type\Orders\EditType;
use Admingenerated\NitraTopsBundle\BaseOrdersController\EditController as BaseEditController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\Form;
use Nitra\TopsBundle\Entity\Buyer;

/**
 * EditController
 */
class EditController extends BaseEditController
{

    /**
     * массив объектов позиций заказов для удаления 
     * @var array \Nitra\OrderBundle\Entity\OrderEntry
     */
    private $removeOrderEntry;

    /** @DI\Inject("doctrine.orm.entity_manager") */
    private $em;

    public function __construct()
    {
        // обнулить массив объектов позиций заказов для удаления 
        $this->removeOrderEntry = array();
    }

    protected function getEditType()
    {
        $type = new EditType($this->getDoctrine()->getEntityManager());
        $type->setSecurityContext($this->get('security.context'));

        return $type;
    }

    /**
     * preBindRequest
     * @param \Nitra\OrderBundle\Entity\Order $Order your \Nitra\OrderBundle\Entity\Order object
     */
    public function preBindRequest(\Nitra\TopsBundle\Entity\Orders $Orders)
    {

        // наполнить массив позиций заказов до сохранения 
        $this->removeOrderEntry = array();
        foreach ($Orders->getOrderEntry() as $orderEntry) {
            $this->removeOrderEntry[$orderEntry->getId()] = $orderEntry;
        }


        // получить тип формы
        $formType = $this->getEditType();

        // получть данные формы 
        $formData = $this->getRequest()->get($formType->getName());

        // получить пользователя 
        $buyer = $this->em->getRepository('NitraTopsBundle:Buyer')->find($formData['buyer_name']['id']);

        // Если пользователь не найден
        if (!$buyer) {
            // покупатель не найден создать нового 
            $buyer = new Buyer();
            $buyer->setName($formData['buyer_name']['name']);
            $buyer->setPhone($formData['buyer_phone']['name']);
            $buyer->setAddress($formData["address"]);
            $this->em->persist($buyer);
        }
        $totalCost=0;
        $totalCost +=  $formData["deliveryCost"];
        foreach ( $formData["orderEntry"] as $oe){
            $totalCost += ($oe['assemblyCost']+$oe['price'])*$oe['quantity'];
        }
         $Orders->setTotal($totalCost);

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
                $orderEntry->setOrder($Orders);
                    $orderEntry->setStatus('new');
                $this->em->persist($orderEntry);
            }
            // Отсеиваем позиции, которые пришли в посте
            if (isset($this->removeOrderEntry[$orderEntry->getId()])) {
                // позиция которая сохраниться в заказе удаляется из массива позиций на удаление
                unset($this->removeOrderEntry[$orderEntry->getId()]);
            }
        }

        foreach ($this->removeOrderEntry as $orderEntry) {
            $this->em->remove($orderEntry);
        }
    }

}
