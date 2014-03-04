<?php

namespace Nitra\TopsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nitra\TopsBundle\Entity\OrderEntry;

class LoadOrderEntryData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $o = 1;
        $statuses = array('new', 'work', 'ready');
        for ($i = 1; $i < 41; $i++) {
            $p = rand(1, 40);
            $q = rand(1, 10);
            $status = rand(0, 2);
            $production = $this->getReference("product$p");
            $order = $this->getReference("Order$o");
            $sum1 = rand(1, $order->getAmount());
            $assemblyCost = rand(1, 500);
            $orderEntry1 = new OrderEntry();
            $orderEntry1
                    ->setAssemblyCost($assemblyCost) //sborka
                    ->setColor("Цвет $i")
                    ->setComment("Фикстуры")
                    ->setOrder($order)
                    ->setOrientation("Правый")
                    ->setPrice($sum1)
                    ->setProduction($production)
                    ->setQuantity($q)
                    ->setStatus($statuses[$status]);
            $manager->persist($orderEntry1);
            
            $p = rand(1, 40);
            $q = rand(1, 10);
            $status = rand(0, 2);
            $production = $this->getReference("product$p");
            $sum2 = rand(1, $order->getAmount() - $sum1);
            $assemblyCost = rand(1, 500);
            $orderEntry2 = new OrderEntry();
            $orderEntry2
                    ->setAssemblyCost($assemblyCost) //sborka
                    ->setColor("Цвет $i")
                    ->setComment("Фикстуры")
                    ->setOrder($order)
                    ->setOrientation("Левый")
                    ->setPrice($sum2)
                    ->setProduction($production)
                    ->setQuantity($q)
                    ->setStatus($statuses[$status]);
            $manager->persist($orderEntry2);
            $o++;
        }

        // сохранить 
        $manager->flush();
    }

    public function getOrder()
    {
        return 70;
    }

}
