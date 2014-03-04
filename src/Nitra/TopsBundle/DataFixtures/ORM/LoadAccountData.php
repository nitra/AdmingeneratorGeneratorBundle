<?php

namespace Nitra\TopsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nitra\TopsBundle\Entity\Account;

class LoadAccountData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $Account1 = new Account();
        $Account1
                ->setName("Приват")
                ->setRequisites("7777 7777 7777 7777");
        $manager->persist($Account1);
        $this->addReference('account1', $Account1);

        $Account2 = new Account();
        $Account2
                ->setName("NBU")
                ->setRequisites("1234 4321 1234 4331");
        $manager->persist($Account2);
        $this->addReference('account2', $Account2);

        $Account3 = new Account();
        $Account3
                ->setName("EXIM Банк")
                ->setRequisites("5555 4321 2222 4331");
        $manager->persist($Account3);
        $this->addReference('account3', $Account3);


        $manager->flush();
    }

    public function getOrder()
    {
        return 20;
    }

}
