<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditUserType extends AbstractType
{
    /**
     * Formulaire pour modifier un utilisateur
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email', EmailType::class,[
            'constraints' => [
                new NotBlank([
                    'message' => 'Merci d\'entrer un e-mail',
                ]),
            ],
            'label' => 'E-mail',
            'required' => true,
            'attr' => [
                'class' =>'form-control mt-1 mb-3',
                'style' =>'border: 1px solid #00C981; background-color: #0C4160; color: white'
        ],
        ])
        ->add('roles', ChoiceType::class, [
            'choices' => [
                'Externe' => 'ROLE_EXT',
                'Apprenant' => 'ROLE_APP',
                'Administrateur' => 'ROLE_ADMIN'
            ],
            'expanded' => true,
            'multiple' => true,
            'label' => 'Rôles :',
            'attr' => [
                'class' =>'mt-1',
        ],
        ])
        ->add('valider', SubmitType::class, [
            'attr' => [
                'class' =>'btn btn-light mt-3',
                'style' =>'background-color: #0C4160; color: white; border: 1px solid #00C981'
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
