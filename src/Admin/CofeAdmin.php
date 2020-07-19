<?php

namespace App\Admin;

use App\Entity\Cofe;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CofeAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', TextType::class, ['label' => 'Название'])
            ->add('slug', TextType::class, ['label' => 'Псевдоним'])
            ->add('price', TextType::class, ['label' => 'Цена'])
            ->add('image', TextType::class, ['label' => 'Изображение'])
            ->add('description', TextareaType::class, ['label' => 'Описание'])
            ->add('categoryId', ChoiceType::class, [
                'label' => 'Категория',
                'required' => true,
                'choices' => array_flip(Cofe::CATEGORIES),
                'expanded' => true,
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name', null, ['label' => 'Название'])
            ->add('slug', null, ['label' => 'Псевдоним'])
            ->add('price', null, ['label' => 'Цена']);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')
            ->addIdentifier('name', null, ['label' => 'Название'])
            ->add('slug', null, ['label' => 'Псевдоним'])
            ->add('price', null, ['label' => 'Цена']);
    }

    public function toString($object)
    {
        return $object instanceof Cofe
            ? $object->getName()
            : 'Кофе'; // shown in the breadcrumb on the create view
    }
}