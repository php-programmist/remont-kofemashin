<?php

namespace App\Admin;

use App\Entity\Service;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class ServiceAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', TextType::class, ['label' => 'Название'])
                   ->add('alias', TextType::class, ['label' => 'Псевдоним'])
                   ->add('seo_name', TextType::class, ['label' => 'Название для SEO'])
                   ->add('price', null, ['label' => 'Цена'])
                   ->add('is_service', null, ['label' => 'Услуга?'])
                   ->add('text', null, ['label' => 'Текст']);
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name', null, ['label' => 'Название'])
                       ->add('alias', null, ['label' => 'Псевдоним'])
                       ->add('seo_name', null, ['label' => 'Название для SEO'])
                       ->add('price', null, ['label' => 'Цена'])
                       ->add('is_service', null, ['label' => 'Услуга?']);
    }
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')
                   ->addIdentifier('name', null, ['label' => 'Название'])
                   ->add('alias', TextType::class, ['label' => 'Псевдоним'])
                   ->add('seo_name', TextType::class, ['label' => 'Название для SEO'])
                   ->add('price', null, ['label' => 'Цена'])
                   ->add('is_service', null, ['label' => 'Услуга?'])
        ;
    }
    
    public function toString($object)
    {
        return $object instanceof Service
            ? $object->getName()
            : 'Услуга'; // shown in the breadcrumb on the create view
    }
}