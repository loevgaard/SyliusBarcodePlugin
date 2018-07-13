<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\Form\Extension;

use Sylius\Bundle\ProductBundle\Form\Type\ProductVariantType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductVariantTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('barcode', TextType::class, [
            'required' => false,
            'label' => 'loevgaard_sylius_barcode.form.product_variant.barcode',
        ]);
    }

    public function getExtendedType(): string
    {
        return ProductVariantType::class;
    }
}
