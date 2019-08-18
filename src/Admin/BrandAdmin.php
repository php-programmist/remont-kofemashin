<?php
namespace App\Admin;

use App\Entity\Brand;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class BrandAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', TextType::class,['label'=>'Название'])
                   ->add('alias', TextType::class,['label'=>'Псевдоним'])
                   ->add('logo', TextType::class,['label'=>'Логотип'])
                   ->add('image', TextType::class,['label'=>'Изображение']);
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name',null,['label'=>'Название'])
                       ->add('alias',null,['label'=>'Псевдоним'])
                       ->add('logo',null,['label'=>'Логотип'])
                       ->add('image',null,['label'=>'Изображение']);
    }
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')
                   ->addIdentifier('name',null,['label'=>'Название'])
                   ->add('alias',null,['label'=>'Псевдоним'])
                   ->add('logo',null,['label'=>'Логотип'])
                   ->add('image',null,['label'=>'Изображение']);
    }
    
    public function toString($object)
    {
        return $object instanceof Brand
            ? $object->getName()
            : 'Бренд'; // shown in the breadcrumb on the create view
    }
}