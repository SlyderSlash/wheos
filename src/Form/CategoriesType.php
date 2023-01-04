<?php

namespace App\Form;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', options:[
                'label' => 'Titre',
            ])
            //->add('createdAt')
            //->add('parent',EntityType::class,[
            //    'class' => Categories::class,
                //'mapped' => false,
              //  ])
            ->add('parent',EntityType::class,[
                'class' => Categories::class,
                'label' => 'Catégorie',
                //'mapped' => false,
                'choice_label' => 'name',
                'group_by' => 'parent.name',
                'query_builder' => function(CategoriesRepository $cr){
                    return $cr->createQueryBuilder('c')
                    ->where('c.parent IS NULL')
                    ->orderBy('c.name','ASC')
                    ;
                },
                'allow_extra_fields' => 'yes'
                ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categories::class,
        ]);
    }
}
