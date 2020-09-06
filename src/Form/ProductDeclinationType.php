<?php

namespace App\Form;

use App\Entity\ProductDeclination;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductDeclinationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => false,
                'imagine_pattern' => 'squared_thumbnail_small',
                'asset_helper' => true,
            ])
            ->add('quantity')
            ->add('price')
            ->add('attributes', null, [
                'attr' => ['size' => 15],
                'group_by' => function($choice) {
                    return ucfirst($choice->getAttributeCategory()->getName());
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductDeclination::class,
        ]);
    }
}
