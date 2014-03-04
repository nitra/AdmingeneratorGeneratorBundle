<?php 
namespace Nitra\TopsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nitra\TopsBundle\Entity\Orders;

class LoadOrdersData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
//        $statuses = array('new', 'process', 'pre_document', 'to_work', 'work', 'ready', 'shipped');
        $statuses = array('Новый', 'Обработано', 'Подготовка документов', 'Передано на производство', 'В работе', 'Готов', 'Отгружено');
        for ($i = 1; $i < 41; $i++) {
            $name = "Order$i";
            $amount = rand(1, 99999);
            $deliveryCost = rand(1, 999);
            $repairedCost = rand(1, 999);
            $b = rand(1, 10);
            $s = rand(0, 6);
            $$name = new Orders();
            $$name
                    ->setAddress(" Адрес по заказу $i")
                    ->setAmount($amount)
                    ->setBuyer($this->getReference("buyer$b"))
                    ->setComment('Фикстуры')
                    ->setDeliveryCost($deliveryCost)
                    ->setDeliveryDate(new \DateTime())
                    ->setMadeAt(new \DateTime())
                    ->setRepairedComment('Коммент доставки')
                    ->setRepairedCost($repairedCost)
                    ->setStatus($statuses[$s]);
            $manager->persist($$name);
            $this->addReference($name, $$name);
        }
        // сохранить 
        $manager->flush();
    }

    public function getOrder()
    {
        return 60;
    }

}
