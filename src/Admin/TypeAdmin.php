<?php
namespace App\Admin;

use App\Entity\Type;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class TypeAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', TextType::class,['label'=>'Название'])
                   ->add('metaTitle', TextType::class,['label'=>'Мета заголовок'])
                   ->add('alias', TextType::class,['label'=>'Псевдоним'])
                   ->add('image', TextType::class,['label'=>'Изображение'])
                   ->add('text', TextareaType::class,['label'=>'Текст']);
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name',null,['label'=>'Название'])
                       ->add('alias',null,['label'=>'Псевдоним'])
                       ->add('image',null,['label'=>'Изображение']);
    }
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')
                   ->addIdentifier('name',null,['label'=>'Название'])
                   ->add('metaTitle', TextType::class,['label'=>'Мета заголовок'])
                   ->add('alias',null,['label'=>'Псевдоним'])
                   ->add('image',null,['label'=>'Изображение']);
    }
    
    public function toString($object)
    {
        return $object instanceof Type
            ? $object->getName()
            : 'Тип'; // shown in the breadcrumb on the create view
    }
}