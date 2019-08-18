<?php

namespace App\Admin;

use App\Entity\Brand;
use App\Entity\Model;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class ModelAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', TextType::class, ['label' => 'Название'])
                   ->add('alias', TextType::class, ['label' => 'Псевдоним'])
                   ->add('brand', ModelType::class, [
                       'class'    => Brand::class,
                       'property' => 'name',
                       'label'    => 'Бренд',
                   ]);
        
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name',null,['label'=>'Название'])
                       ->add('alias',null,['label'=>'Псевдоним'])
                       ->add('brand',null,['label'=>'Бренд'],EntityType::class, [
                           'class' => Brand::class,
                           'choice_label' => 'name',
                       ]);
    }
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')
                   ->addIdentifier('name', null, ['label' => 'Название'])
                   ->add('alias', null, ['label' => 'Псевдоним'])
                   ->add('brand.name', null, ['label' => 'Бренд']);
    }
    
    public function toString($object)
    {
        return $object instanceof Model
            ? $object->getName()
            : 'Модель'; // shown in the breadcrumb on the create view
    }
}