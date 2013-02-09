<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Sonata\AdminBundle\Form\Type\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

class ChoiceType extends AbstractType
{
    const TYPE_CONTAINS = 1;

    const TYPE_NOT_CONTAINS = 2;

    const TYPE_EQUAL = 3;

    protected $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'sonata_type_filter_choice';
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $choices = array(
            self::TYPE_CONTAINS        => $this->translator->trans('label_type_contains', array(), 'SonataAdminBundle'),
            self::TYPE_NOT_CONTAINS    => $this->translator->trans('label_type_not_contains', array(), 'SonataAdminBundle'),
            self::TYPE_EQUAL           => $this->translator->trans('label_type_equals', array(), 'SonataAdminBundle'),
        );

        if ('choice' == $options['field_type']) {
            $options['field_options']['value_strategy'] = ChoiceList::COPY_CHOICE;
        }

        $builder
            ->add('type', 'choice', array('choices' => $choices, 'required' => false, 'value_strategy' => ChoiceList::COPY_CHOICE))
            ->add('value', $options['field_type'], array_merge(array('required' => false), $options['field_options']))
        ;
    }

    public function getDefaultOptions(array $options)
    {
        $defaultOptions = array(
            'field_type'       => 'choice',
            'field_options'    => array()
        );

        $options = array_replace($options, $defaultOptions);

        return $options;
    }
}
