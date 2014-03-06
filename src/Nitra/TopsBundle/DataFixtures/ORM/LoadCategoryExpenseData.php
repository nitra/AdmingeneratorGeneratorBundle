<?php

namespace Nitra\TopsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nitra\TopsBundle\Entity\CategoryExpense;

class LoadCategoryExpenseData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 6; $i++) {
            $name = "CategoryExpense$i";
            $$name = new CategoryExpense();
            $$name
                    ->setName("Категория расходов №$i");
            $manager->persist($$name);
            $this->addReference($name, $$name);
        }
        // сохранить 
        $manager->flush();
    }

    public function getOrder()
    {
        return 30;
    }


}
