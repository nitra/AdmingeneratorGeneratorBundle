<?php

namespace Nitra\TopsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 *
 *       $options = array(
 *           'autocompleteActionRouting' => '',      // Роутинг на контроллер, который будет отдавать данные для списка
 *           'afterItemSelectJavascript' => '',      // Дополнительные Javascript действия после выбора из списка
 *           'extraParamsString' => '',              // Дополнительные Get-параметры отсылаемые в Controller
 *           'minChars' => 2,                        // Минимальная длина запроса для срабатывания автозаполнения
 *           'deferRequestBy' => 10,                 // Задержка запроса (мсек), на случай, если мы не хотим слать миллион запросов, пока пользователь печатает.
 *           'maxHeight' => 400,                     // Максимальная высота списка подсказок, в пикселях
 *           'width' => 300                          // Ширина списка
 *       );
 *
 *
 *
 * Пример контроллера
 * public function testAjaxAction () {
 *
 *       // То что приходит из поля ввода (строка поиска)
 *       $search_str = $this->getRequest()->get('q');
 *
 *       $autocomplete_return = array();
 *
 *       $return_pos['value'] = '2'; // Идентификатор записи, прийдет в посте
 *       $return_pos['label'] = 'label2 Отображается при выборе из списка';  // Название записи, прийдет в посте
 *       $return_pos['display'] = 'label2 отображение во время поиска';
 *       $return_pos['dop_info'] = 'label2dop Дополнительная информация, нигде не отображается';
 *       $return_pos['json_data'] = array(
 *           'id' => '44',
 *           'comment' => 'Test comment2'
 *       );
 *       array_push($autocomplete_return,$return_pos['display'] . "|" . $return_pos['label'] . "|" . $return_pos['value'] . '|' . json_encode($return_pos['json_data']) );
 *
 *
 *       $return_pos['value'] = '3'; // Идентификатор записи, прийдет в посте
 *       $return_pos['label'] = 'label3 Отображается при выборе из списка';  // Название записи, прийдет в посте
 *       $return_pos['display'] = 'label3 отображение во время поиска';
 *       $return_pos['dop_info'] = 'label3dop Дополнительная информация, нигде не отображается';
 *
 *       $return_pos['json_data'] = array(
 *           'id' => '55',
 *           'comment' => 'Test comment3'
 *       );
 *
 *       array_push($autocomplete_return,$return_pos['display'] . "|" . $return_pos['label'] . "|" . $return_pos['value'] . '|' . json_encode($return_pos['json_data']) );
 *
 *       return new Response( implode("\n", $autocomplete_return) );
 *
 *   }
 *
 *
 */
class AjaxAutocompleteType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', 'text')
                ->add('id', 'hidden');
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {

        $view->vars['autocompleteActionRouting'] = $options['autocompleteActionRouting'];
        $view->vars['afterItemSelectJavascript'] = $options['afterItemSelectJavascript'];
        $view->vars['extraParamsString'] = $options['extraParamsString'];
        $view->vars['minChars'] = $options['minChars'];
        $view->vars['deferRequestBy'] = $options['deferRequestBy'];
        $view->vars['maxHeight'] = $options['maxHeight'];
        $view->vars['width'] = $options['width'];

    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'autocompleteActionRouting' => '',    // Роутинг на контроллер, который будет отдавать данные для списка
            'afterItemSelectJavascript' => '',   // Дополнительные Javascript действия после выбора из списка
            'extraParamsString' => '',            // Дополнительные Get-параметры отсылаемые в Controller
            'minChars' => 2,                        // Минимальная длина запроса для срабатывания автозаполнения
            'deferRequestBy' => 10,                 // Задержка запроса (мсек), на случай, если мы не хотим слать миллион запросов, пока пользователь печатает.
            'maxHeight' => 400,                     // Максимальная высота списка подсказок, в пикселях
            'width' => 300                          // Ширина списка
        ));
    }

    public function getName()
    {
        return 'ajax_autocomplete';
    }

}
