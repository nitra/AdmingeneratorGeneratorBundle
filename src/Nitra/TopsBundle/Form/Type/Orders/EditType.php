<?php

namespace Nitra\TopsBundle\Form\Type\Orders;

use Admingenerated\NitraTopsBundle\Form\BaseOrdersType\EditType as BaseEditType;
use Symfony\Component\Form\FormBuilderInterface;
use Nitra\TopsBundle\Form\Type\OrderEntry\OrderEntryType;
use Doctrine\ORM\EntityRepository;
use Nitra\TopsBundle\Form\DataTransformer\ProductionIdToEntityTransformer;
use Doctrine\ORM\EntityManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Admingenerator\GeneratorBundle\Form\Type\AjaxAutocompleteType;
use Symfony\Component\Validator\Constraints;

/**
 * EditType
 */
class EditType extends BaseEditType
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

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        var_dump($options->toArray());die;
//        die('ss');
        parent::buildForm($builder, $options);


        // виджет позиции заказа
        $builder->add('orderEntry', 'collection', array(
            'type' => new OrderEntryType($this->em),
            'allow_add' => true,
             'label' => ' ',
            'allow_delete' => true,
            'prototype' => true,
            'by_reference' => false
        ));

//        $builder->add('product_no_standart','text', array('mapped' => false, 'required' => false, 'label' => ' ',));
        // проверить связь с объектом заказа в базе
        if ($options['data']->getId()) {
            // автокомплит объект полкупателя
            $options['buyer_object'] = $options['data']->getBuyer();

            // автокомплит  имя покупателя
            $options['buyer_name_add_options']['data']['name'] = $options['data']->getBuyer()->getName();
            $options['buyer_name_add_options']['data']['id'] = $options['data']->getBuyer()->getId();

            // автокомплит телефон покупателя
            $options['buyer_phone_add_options']['data']['name'] = $options['data']->getBuyer()->getPhone();
            $options['buyer_phone_add_options']['data']['id'] = $options['data']->getBuyer()->getId();
        }

        $afterJavaScriptProduct = " json_data = eval('('+row.extra[2]+')');";


//                ;
        $builder->add('add_order_entry', new AjaxAutocompleteType(), array(
            'required' => true,
            'mapped' => false,
            'extraParamsString' => '',
            'autocompleteActionRouting' => 'Nitra_TopsBundle_Get_AddOE_Autocomplete',
            'afterItemSelectJavascript' => $afterJavaScriptProduct,
                )
        );

        // автокомплит поле имя покупателя
        $afterJavaScriptBuyerName = "  
            json_data = eval('('+row.extra[2]+')');           
            $('#edit_orders_buyer_phone_name').val( json_data.phone );
            $('#edit_orders_buyer_name_id').val( json_data.id );";
        $builder->add('buyer_name', new AjaxAutocompleteType(), array_merge(array(
            'label' => 'Покупатель',
            'required' => true,
            'mapped' => false,
            'autocompleteActionRouting' => 'Nitra_TopsBundle_Get_Buyer_Autocomplete',
            'afterItemSelectJavascript' => $afterJavaScriptBuyerName,
                        ), $options['buyer_name_add_options']
        ));



        // автокомплит поле телефон покупателя
        $afterJavaScriptBuyerPhone = "  
            json_data = eval('('+row.extra[2]+')');           
            console.log( json_data);
            $('#edit_orders_buyer_name_name').val( json_data.name );
            $('#edit_orders_buyer_name_id').val( json_data.id );";
        $builder->add('buyer_phone', new AjaxAutocompleteType(), array_merge(array(
            'required' => true,
            'mapped' => false,
            'label' => 'Телефон',
            'autocompleteActionRouting' => 'Nitra_TopsBundle_Get_Buyer_Autocomplete',
            'afterItemSelectJavascript' => $afterJavaScriptBuyerPhone,
            'extraParamsString' => 'search_by: \'phone\'',
                        ), $options['buyer_phone_add_options']
        ));


        // установить трансформер для склада позиции
//        $builder->add(
//                $builder->create('production', 'hidden', array('required' => true, 'attr' => array('class' => 'order_entry_production')))
//                        ->addModelTransformer(new ProductionIdToEntityTransformer($this->em))
//        );
    }

    /**
     * установить массив $options по умолчанию
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        // установить $options по умолчанию
        $resolver->setDefaults(array(
            // данные автокомплита имя покупателя
            'buyer_name_add_options' => array('data' => array('name' => null, 'id' => null,)),
            // данные автокомплита телефон покупателя
            'buyer_phone_add_options' => array('data' => array('name' => null, 'id' => null,))
        ));
    }

}
