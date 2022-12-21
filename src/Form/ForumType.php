<?php

namespace App\Form;

use App\Entity\Forums;
use App\Entity\Users;
use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('createdAt')
            ->add('isResolved')
            ->add('isClosed')
            ->add('user',EntityType::class,['class' => Users::class])
            ->add('category',EntityType::class,['class' => Categories::class])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forums::class,
        ]);
    }
}
