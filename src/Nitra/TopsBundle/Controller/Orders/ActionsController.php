<?php

namespace Nitra\TopsBundle\Controller\Orders;

use Admingenerated\NitraTopsBundle\BaseOrdersController\ActionsController as BaseActionsController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * ActionsController
 */
class ActionsController extends BaseActionsController
{

    /** @DI\Inject("doctrine.orm.entity_manager") */
    private $em;

    /**
     * выбор покупателей для автоподсказки
     * @Route("/get-buyer-order-autocomplete", name="Nitra_TopsBundle_Get_Buyer_Autocomplete")
     */
    public function buyerAutocompleteAction()
    {
//        die('ddd');
        // То что приходит из поля ввода (строка поиска)
        $search_str = $this->getRequest()->get('q');
        $type_search = $this->getRequest()->get('search_by', 'name');

        $words = preg_split('/\s+/', trim($search_str));

        $where = array();
        foreach ($words AS $word) {

            switch ($type_search) {
                case 'name':
                    $where [] = " b.name LIKE '%" . $word . "%' ";
                    break;

                case 'phone':
                    $where [] = " b.phone LIKE '%" . $word . "%' ";
                    break;

                default :
                    $where [] = " b.id IS NULL ";
            }
        }

        $buyers = $this->em->createQuery("SELECT b FROM NitraTopsBundle:Buyer b WHERE (" . implode(" OR ", $where) . " )")->getResult();

        $autocomplete_return = array();

        foreach ($buyers as $buyer) {

            switch ($type_search) {
                case 'name':
                    $current_buyer_str = $buyer->getName() . "|" . $buyer->getName() . "|" . $buyer->getId() . '|' . json_encode(array('phone' => $buyer->getPhone(), 'name' => $buyer->getName(), 'id' => $buyer->getId()));
                    break;

                case 'phone':
                    $current_buyer_str = $buyer->getPhone() . "|" . $buyer->getPhone() . "|" . $buyer->getId() . '|' . json_encode(array('phone' => $buyer->getPhone(), 'name' => $buyer->getName(), 'id' => $buyer->getId()));

                    break;

                default :
                    break;
            }

            $autocomplete_return[] = $current_buyer_str;
        }

        if ($type_search == 'name') {
            $upName = mb_convert_case($search_str, MB_CASE_TITLE, "UTF-8");
            $autocomplete_return[] = $upName . "\\\\новый покупатель|" . $upName . "|" . "new" . '|' . json_encode(array());
        }
        return new Response(implode("\n", $autocomplete_return));
    }

    /**
     * выбор покупателей для автоподсказки
     * @Route("/get-add-orderEntry-autocomplete", name="Nitra_TopsBundle_Get_AddOE_Autocomplete")
     */
    public function addOEAutocompleteAction()
    {

        $searchStr = $this->getRequest()->get('q');
        $words = preg_split('/\s+/', trim($searchStr));
        $where = array();

        foreach ($words AS $word) {
            $where [] = " p.name LIKE '%" . $word . "%' ";
        }
        $products = $this->em->createQuery("SELECT p FROM NitraTopsBundle:Production p WHERE (" . implode(" OR ", $where) . " )")->getResult();


        foreach ($products as $product) {

            $current_buyer_str = $product->getName() . "|" . $product->getName() . "|" . $product->getId() . '|' .
                    json_encode(array('name' => $product->getName(), 'id' => $product->getId(), 'cost' => $product->getCost(), 'assemblyCost' => $product->getAssemblyCost(), 'file' => $product->getFile()));

            $autocomplete_return[] = $current_buyer_str;
        }

        return new Response(implode("\n", $autocomplete_return));
    }

    /**
     * выбор покупателей для автоподсказки
     * @Route("/change-orderEntry-stautus", name="Nitra_TopsBundle_Post_Change_Status_Order_Entry")
     */
    public function changeOrderEntryStatus()
    {

        $oeId = $this->getRequest()->get('orderEntryId', false);
        $oId = $this->getRequest()->get('orderId', false);
        $oeToStatus = $this->getRequest()->get('toStatus', false);

        if ($oeId) {
            // получить заказ
            $orderEntry = $this->em->getRepository('NitraTopsBundle:OrderEntry')->find($oeId);
            if (!$orderEntry) {
                // позиция заказа не найдена, вернуть массив ошибок 
                return new JsonResponse(array('type' => 'error', 'message' => "Позиция заказа не найдена."));
            }
            
            $orderEntry->setStatus($oeToStatus);
        }
        // получить заказ
        $order = $this->em->getRepository('NitraTopsBundle:Orders')->find($oId);
        if (!$order) {
            // позиция заказа не найдена, вернуть массив ошибок 
            return new JsonResponse(array('type' => 'error', 'message' => "Заказ не найден."));
        }
        
                // сохранить
        $this->em->flush();
        
        // цепочка выполнена успешно
        return new JsonResponse(array('type'=> 'success'));
    }

}
