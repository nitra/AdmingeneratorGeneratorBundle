<?php

namespace Nitra\TopsBundle\Form\Type\Income;

use Admingenerated\NitraTopsBundle\Form\BaseIncomeType\NewType as BaseNewType;


use Symfony\Component\Form\FormBuilderInterface;
use Nitra\TopsBundle\Form\Type\Orders\EditType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Admingenerator\GeneratorBundle\Form\Type\AjaxAutocompleteType;
use Symfony\Component\Validator\Constraints;
/**
 * NewType
 */
class NewType extends BaseNewType
{ /**
 * @var \Doctrine\ORM\EntityManager
 */



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
//        var_dump('dd');die;

       

        parent::buildForm($builder, $options);
    }
    
    
      
    /**
     * setDefaultOptions
     * установить значения формы по умолчанию
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        
        $resolver->setDefaults(array(
            'data_class' => 'Nitra\TopsBundle\Entity\Income',
        ));
        
        $resolver->setRequired(array(
            'em',

        ));
        
        $resolver->setAllowedTypes(array(
            'em' => 'Doctrine\ORM\EntityManager',
            
        ));        
        
    }

}
