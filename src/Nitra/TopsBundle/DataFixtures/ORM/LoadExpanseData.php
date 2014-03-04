<?php

namespace Nitra\TopsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nitra\TopsBundle\Entity\Expanse;

class LoadExpanseData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 21; $i++) {
            $name = "Expanse$i";
            $ce = rand(1, 5);
            $a = rand(1, 3);
            $amount = rand(1,10000);
            $$name = new Expanse();
            $$name
                    ->setAccount($this->getReference("account$a"))
                    ->setAmount($amount)
                    ->setCategoryExpanse($this->getReference("CategoryExpanse$ce"))
                    ->setDate(new \DateTime())
                    ->setComment('Фикстуры');
            $manager->persist($$name);
            $this->addReference($name, $$name);
        }
        // сохранить 
        $manager->flush();
    }

    public function getOrder()
    {
        return 50;
    }

}
