<?php

/*
 * This file is part of the ExpandedCollectionBundle.
 *
 * (c) Abdiel Carrazana <abdielcs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace abdielcs\ExpandedCollectionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Custom form type for render expanded entities collections in a OneToMany association mapping.
 *
 * @author Abdiel Carrazana <abdielcs@gmail.com>
 */
class ExpandedOTMType extends AbstractType
{
    public function getParent()
    {
        return 'entity';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }

    public function getBlockPrefix()
    {
        return 'expanded_otm';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'multiple' => true,
            'expanded' => true,
            'fields' => array(),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'fields' => $options['fields'],
        ));

    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        foreach ($view as $childView) {
            foreach($view->vars['choices'] as $choice){
                if($choice->value == $childView->vars['value']){
                    $childView->vars['object_data'] = $choice->data;
                    break;
                }
            }
        }
    }

}