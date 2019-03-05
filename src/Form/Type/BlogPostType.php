<?php

namespace App\Form\Type;


use Donjohn\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class BlogPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('media', MediaType::class, [
                'label' => 'Un media',
                'media_class' => 'App\Entity\Media',
                'multiple' => false,
                'fine_uploader' => false,
                'provider' => 'image'
            ])
            ->add('medias', MediaType::class, [
                'label' => 'Plusieurs medias',
                'media_class' => 'App\Entity\Media',
                'multiple' => true,
                'fine_uploader' => false,
                'provider' => 'image'
            ])
            ->add('submit', SubmitType::class)
        ;

    }
}