<?php

namespace Nitra\TopsBundle\Form\Type\OrderEntry;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Nitra\TopsBundle\Form\DataTransformer\ProductionIdToEntityTransformer;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class OrderEntryType extends AbstractType
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * Constructor
     * 
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * построить форму позиции заказа
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('quantity', 'text', array('attr' => array('class' => 'quantity')))
                ->add('price')
                ->add('assemblyCost')
                ->add('productName', 'text', array('required' => false, 'label' => ' ',));

        ;
        $formOptions = $this->getFormOption('orientation', array('required' => false, 'choices' => array('Правый' => 'Правый', 'Левый' => 'Левый', '' => ''), 'label' => 'Ориентация',));
        $builder->add('orientation', 'choice', $formOptions);
        // поставщик
//        $builder->add('production', 'entity', array(
//            'class' => 'NitraTopsBundle:Production',
//            'required' => false,
//            'property' => 'name',
//            'mapped' => true
//        ));
//         установить трансформер для склада позиции
        $builder->add(
                $builder->create('production', 'hidden', array('required' => true, 'attr' => array('class' => 'order_entry_production')))
                        ->addModelTransformer(new ProductionIdToEntityTransformer($this->em))
        );
    }

    public function getName()
    {
        return 'nitra_topsbundle_orderentrytype';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nitra\TopsBundle\Entity\OrderEntry'
        ));
    }

    protected function getFormOption($name, array $formOptions)
    {
        return $formOptions;
    }

}
