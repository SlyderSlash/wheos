<?php

namespace App\Form;

use App\Entity\ForumMessages;
use App\Entity\Forums;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForumMessagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content')
            ->add('createdAt')
            ->add('user',EntityType::class,['class' => Users::class])
            ->add('forum',EntityType::class,['class' => Forums::class])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ForumMessages::class,
        ]);
    }
}
