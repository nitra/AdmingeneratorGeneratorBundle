<?php

namespace Admingenerator\GeneratorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DateRangeType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        unset($options['years']);

        $options['from']['required'] = $options['required'];
        $options['to']['required'] = $options['required'];

        if ($options['format']) {
            $options['from']['format'] = $options['format'];
            $options['to']['format'] = $options['format'];
        }
        $options['from']['widget'] = 'single_text';
        $options['to']['widget'] = 'single_text';

        $builder
                ->add('from', new DateType(), $options['from'])
                ->add('to', new DateType(), $options['to']);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'form';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $years = range(date('Y'), date('Y') - 120);

        $resolver->setDefaults(
            array(
            'format' => null,
            'years'  => $years,
            'to'     => array('years' => $years, 'widget' => 'choice'),
            'from'   => array('years' => $years, 'widget' => 'choice'),
            'widget' => 'choice')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'date_range';
    }
}
