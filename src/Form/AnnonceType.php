<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Categorie;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\AnnonceImageType;
use App\Entity\Tag;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AnnonceType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('enabled', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Enable',
                    'choices' => ['Oui' => true, 'Non' => false]
                ])
                ->add('categorie', EntityType::class, [
                    'required' => true,
                    'multiple' => false,
                    'class' => Categorie::class,
                    'choice_label' => 'nom',
                    'label' => 'Catégorie',
                    'attr' => ['class' => 'form-select']
                ])
                ->add('tags', EntityType::class, [
                    'required' => true,
                    'multiple' => true,
                    'expanded' => true,
                    'class' => Tag::class,
                    'choice_label' => 'nom',
                    'label' => 'Tag',
                        //'attr' => ['class' => 'form-select']
                ])
                ->add('titre', TextType::class, [
                    'required' => true,
                    'label' => 'Titre',
                    'attr' => array('placeholder' => 'Titre'),
                ])
                ->add('discreption', TextareaType::class, [
                    'required' => true,
                    'label' => 'discreption',
                    'attr' => array('placeholder' => 'discreption'),
                ])
                ->add('images', CollectionType::class, [
                    'label' => 'Images',
                    'entry_type' => AnnonceImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'prototype_name' => '__annonces__',
                    'by_reference' => false,
                    'attr' => array(
                        'class' => 'annonce-images-collection',
            )])
                ->add('save', SubmitType::class, [
                    'label' => "Sauvegarder",
                ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }

}
