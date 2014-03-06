<?php

namespace Nitra\TopsBundle\Controller\Analitics;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * AnaliticsController
 */

/**
 * @Route("/")
 */
class ActiveController extends Controller
{

    /** @DI\Inject("doctrine.orm.entity_manager") */
    private $em;

    /**
     * Баланси по счетам 
     *
     * @Route("/active")
     * @Template
     */
    public function accountActiveAction(Request $request)
    {
        $from = new \DateTime('first day of this month');
        $to = new \DateTime;
        $accountId = null;
        $res = array(); // список всех движений 
        $balanceBefore = 0; //баланс на начало периода
        $totalIncomes = 0;
        $totalExpenses = 0;

        // создаем фильтр
        $form = $this->createFormBuilder(null)
                ->add('account', 'entity', array(
                    'class' => 'NitraTopsBundle:Account',
                    'required' => false,
                    'empty_value' => '',
                    'label' => 'Счета'))
                ->add('period', 'date_range', array(
                    'label' => 'Період',
                    'format' => 'd MMM y'))
                ->getForm();

        // Обработка фильтра
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $from = $data['period']['from'];
                $to = $data['period']['to'];
                $accountId = $data['account'];
            }
        } else {
            // значения по умолчанию
            $form->setData(array('period' => array('from' => $from, 'to' => $to)));
        }


        $qbe = $this->em->createQueryBuilder(); // получаем все расходы
        $qbi = $this->em->createQueryBuilder(); // получаем все поступления
        $qbeFromPeriod = $this->em->createQueryBuilder();
        $qbiFromPeriod = $this->em->createQueryBuilder();


        $qbe->select('e, a')
                ->from('NitraTopsBundle:Expense', 'e')
                ->leftJoin('e.account', 'a')
                ->where($qbe->expr()->between('e.date', ':from', ':to'))
                ->setParameter('from', $from->format('Y-m-d'))
                ->setParameter('to', $to->format('Y-m-d'));
        // Надходження за період 
        $qbi->select('i, a')
                ->from('NitraTopsBundle:Income', 'i')
                ->leftJoin('i.account', 'a')
                ->where($qbi->expr()->between('i.date', ':from', ':to'))
                ->setParameter('from', $from->format('Y-m-d'))
                ->setParameter('to', $to->format('Y-m-d'));

        $qbeFromPeriod->select('SUM(e.amount)')
                ->from('NitraTopsBundle:Expense', 'e')
                ->where('e.date <= :from')
                ->setParameter('from', $from->format('Y-m-d'));

        $qbiFromPeriod->select('SUM(i.amount)')
                ->from('NitraTopsBundle:Income', 'i')
                ->where('i.date <= :from')
                ->setParameter('from', $from->format('Y-m-d'));


//если выбран фильтр по счету
        if ($accountId) {
            $qbe->andWhere('e.account = :account')
                    ->setParameter('account', $accountId);
            $qbi->andWhere('i.account = :account')
                    ->setParameter('account', $accountId);
            $qbeFromPeriod->andWhere('e.account = :account')
                    ->setParameter('account', $accountId);
            $qbiFromPeriod->andWhere('i.account = :account')
                    ->setParameter('account', $accountId);
        }




        $expenseTotalFrom = $qbeFromPeriod->getQuery()->getOneOrNullResult();
        $incomeTotalFrom = $qbiFromPeriod->getQuery()->getOneOrNullResult();
        $balanceBefore = $incomeTotalFrom[1] - $expenseTotalFrom[1];
        $incomes = $qbi->getQuery()->getResult();
        $expenses = $qbe->getQuery()->getResult();

        /*
         * $incomes все поступления по выбранным условиям
         */
        foreach ($incomes as $income) {
            $order = '';
            if ($income->getOrders()) {
                $order = ' Заказ №' . $income->getOrders()->getId();
            }
            $res[] = array(
                'date' => $income->getDate(),
                'type' => 'plus',
                'description' => 'Поступление(№ ' . $income->getId() . ') на счет: ' . $income->getAccount()->getName() . ' ' . $income->getComment() . $order,
                'amount' => $income->getAmount()
            );

            $totalIncomes += $income->getAmount();
        }

        /*
         * $expenses все поступления по выбранным условиям
         */
        $totalExpenses = 0;
        foreach ($expenses as $expense) {
            $res[] = array(
                'date' => $expense->getDate(),
                'type' => 'minus',
                'description' => 'Расход(№ ' . $expense->getId() . ') на счет: ' . $expense->getAccount()->getName() . ' ' . $expense->getComment() . ' ' . $expense->getComment() . $order,
                'amount' => $expense->getAmount()
            );

            $totalExpenses += $expense->getAmount();
        }


        return array(
            'form' => $form->createView(),
            'res' => $res,
            'balanceBefore' => $balanceBefore,
            'balanceAfter' => $balanceBefore + $totalIncomes - $totalExpenses,
            'totalIncomes' => $totalIncomes,
            'totalExpenses' => $totalExpenses
        );
    }

}
