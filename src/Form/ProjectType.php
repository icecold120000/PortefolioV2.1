<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomProjet', TextType::class,[
                'label' => 'Le nom du projet',
                'required' => false,
            ])
            ->add('dateDebut', DateType::class, [
                'label' => 'La date de début du projet ',
                'html5' => false,
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'required' => false,
            ])
            ->add('dateFin', DateType::class, [
                'label' => 'La date de fin du projet ',
                'html5' => false,
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'required' => false,
            ])
            ->add('descripProjet', TextareaType::class,[
                'label' => 'La description du projet',
                'required' => false,
            ])
            ->add('doc', FileType::class, [
                'label' => 'La documentation du projet(pdf)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez sélectionner un fichier pdf',
                        'maxSizeMessage' => 'Veuillez transférer un fichier ayant pour taille maximum de {{limit}}',
                    ])
                ],
            ])
            ->add('vig', FileType::class, [
                'label' => 'La vignette du projet(png/jpeg/jpg)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Veuillez sélectionner un fichier png/jpeg/jpg',
                        'maxSizeMessage' => 'Veuillez transférer un fichier ayant pour taille maximum de {{limit}}',
                    ])
                ],
            ])
            ->add('lienProjet', TextType::class, [
                'label' => 'Le lien du projet',
                'required' => false,
            ])
            ->add('technologie', TextareaType::class,[
                'label' => 'Les technologies utilisées',
                'required' => false,
            ])
            ->add('cdc', FileType::class, [
                'label' => 'Le cahier des charges du projet(pdf)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez sélectionner un fichier pdf',
                        'maxSizeMessage' => 'Veuillez transférer un fichier ayant pour taille maximum de {{limit}}',
                    ])
                ],
            ])
            ->add('veille', TextareaType::class,[
                'label' => 'Les veilles faites pour le projet',
                'required' => false,
            ])
            ->add('participant', TextareaType::class,[
                'label' => 'Les participants au projet',
                'required' => false,
            ])
            ->add('outil', TextareaType::class,[
                'label' => 'Les outils utilisés',
                'required' => false,
            ])
            ->add('missionRealise', TextareaType::class,[
                'label' => 'Les missions réalisées',
                'required' => false,
            ])
            ->add('contexte', TextareaType::class,[
                'label' => 'Le contexte du projet',
                'required' => false,
            ])
            ->add('encadrant', TextareaType::class,[
                'label' => 'Les encadrants du projet',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
            'attr' => ['id' => 'projetForm']
        ]);
    }
}
