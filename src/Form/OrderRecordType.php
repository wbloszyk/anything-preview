<?php

namespace App\Form;

use App\Entity\OrderRecord;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderRecordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('productName', null, [
                'label' => 'Nazwa produktu'
            ])
            ->add('vat', null, [
                'label' => 'stawka vat [%]'
            ])
            ->add('priceExcl', null, [
                'label' => 'Cena netto'
            ])
            ->add('priceIncl', null, [
                'label' => 'Cena brutto'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderRecord::class,
        ]);
    }
}
