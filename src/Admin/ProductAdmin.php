<?php
/**
 * Created by PhpStorm.
 * User: skillup_student
 * Date: 26.04.19
 * Time: 20:39
 */

namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ProductAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name') //делает ссылку на форму редактирование
            ->addIdentifier('descriprtion')
            ->add('price')
            ->add('count')
            ->add('isTop')
            ;
    }
    // фильтрация
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('name')
            ->add('descriprion')
            ->add('price')
            ->add('count')
            ->add('isTop')
        ;
    }

    //
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('name')
            ->add('descriprion')
            ->add('price')
            ->add('count')
            ->add('isTop')
        ;
    }


}