<?php

namespace Nitra\TopsBundle\Controller\Orders;

use Admingenerated\NitraTopsBundle\BaseOrdersController\ListController as BaseListController;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Nitra\TopsBundle\Entity\Orders;

/**
 * ListController
 */
class ListController extends BaseListController
{

    /**
     * Отображение строки заказа
     * @Route("/{pk}-render-tr", name="Nitra_TopsBundle_Orders_Render_Tr", options={"expose"=true})
     * @ParamConverter("orders", class="NitraTopsBundle:Orders", options={"id" = "pk"})
     * @Template("NitraTopsBundle:OrdersList:row.html.twig")
     */
    public function orderRenderTrAction(Orders $orders)
    {
 
        // вернуть массив данных передаваемых в шаблон 
        return array(
            'Orders' => $orders,
        );
    }

}
