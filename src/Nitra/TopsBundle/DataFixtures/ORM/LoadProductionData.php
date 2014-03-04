<?php

namespace Nitra\TopsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nitra\TopsBundle\Entity\Production;

class LoadProductionData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 41; $i++) {
            $name = "product$i";
            $cost = rand(1, 5000);
            $assemblyCost = rand(1, 100);
            $$name = new Production();
            $$name
                    ->setName($name)
                    ->setArt("ART$i")
                    ->setCost($cost)
                    ->setAssemblyCost($assemblyCost);

            $manager->persist($$name);
            $this->addReference($name, $$name);
        }
        // сохранить 
        $manager->flush();
    }

    public function getOrder()
    {
        return 10;
    }

}
