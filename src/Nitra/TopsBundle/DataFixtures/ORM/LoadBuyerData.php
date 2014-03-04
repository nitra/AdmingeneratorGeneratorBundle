<?php

namespace Nitra\TopsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nitra\TopsBundle\Entity\Buyer;

class LoadBuyerData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        // создать записи 
        for ($index = 0; $index < 11; $index++) {

            // название переменной 
            $objName = 'buyer' . $index;
            $t = rand(1, 9999999);
            // создать объект 
            $$objName = new Buyer();
            $$objName
                    ->setName('Покупатель ' . $index)
                    ->setPhone('+38050' . str_pad($t, 7, '0'))
                    ->setAddress('Адрес покупателя ' . $index)
                    ->setEmail("buyer$index@mail.ru");
            $manager->persist($$objName);

            // запомнить
            $this->addReference($objName, $$objName);
        }

        // сохранить 
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 40; // the order in which fixtures will be loaded
    }

}
