<?php

namespace App\Form;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\Content;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug')
            ->add('translations', TranslationsType::class, [
                'locales' => ['en','id'],
                'default_locale' => ['en'],
                'required_locales' => ['en'],
                'fields' => [
                    'title' => [
                        'field_type' => TextType::class,
                        'locale_options' => [
                            'en' => [
                                'required' => true,
                                'constraints' => [new NotBlank()],
                            ]
                        ]
                    ],
                    'metaTitle' => [
                        'field_type' => TextType::class,
                        'locale_options' => [
                            'en' => [
                                'required' => true,
                                'constraints' => [new NotBlank()],
                            ]
                        ]
                    ],
                    'metaDescription' => [
                        'field_type' => TextType::class,
                        'locale_options' => [
                            'en' => [
                                'required' => true,
                                'constraints' => [new NotBlank()],
                            ]
                        ]
                    ]
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Content::class,
        ]);
    }
}
