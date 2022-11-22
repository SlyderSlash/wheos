<?php

namespace App\Form;

use App\Entity\Files;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\File\File;

class FilesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        /** @var string $dest */
        global $dest;

        if(!@chdir($dest)) {
            mkdir($dest);
            chdir($dest);
        }

        $builder
        ->add('brochure', FileType::class, [
            'label' => 'Brochure (PDF file)',
            'mapped' => false,
            'required' => false,
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'application/pdf',
                        'application/x-pdf',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid PDF document',
                ])
            ],
        ]);        
    }
}