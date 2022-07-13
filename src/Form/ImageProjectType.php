<?php

namespace App\Form;

use App\Entity\ImageProject;
use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImageProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', FileType::class, [
                'label' => 'L\'image de l\'événement',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Veuillez sélectionner un fichier png/jpeg/jpg',
                        'maxSizeMessage' => 'Veuillez transférer un fichier ayant pour taille maximum de 2048ko',
                    ])
                ]
            ])
            ->add('projet', EntityType::class,[
                'label' => 'Le projet associé à cette image',
                'class' => Project::class,
                'query_builder' => function (ProjectRepository $er) {
                    return $er->createQueryBuilder('pr')
                        ->orderBy('pr.id', 'ASC');
                },
                'choice_label' => 'nomProjet',
                'required' => true,
            ])
        ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ImageProject::class,
        ]);
    }
}
