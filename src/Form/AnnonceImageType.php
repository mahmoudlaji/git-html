<?php

namespace App\Form;

use App\Entity\ImageAnnonces;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AnnonceImageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('imageFile', VichImageType::class, [
                    'required' => true,
                    'allow_delete' => true,
                    'download_uri' => true,
                    'image_uri' => false,
                    'label' => 'Image',
                    'help' => 'La taille maximale est 5M',
                ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => ImageAnnonces::class,
        ]);
    }

}
