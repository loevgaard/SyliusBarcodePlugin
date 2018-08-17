<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Form\Extension;

use Loevgaard\SyliusBarcodePlugin\Validator\Constraints\Barcode;
use Sylius\Bundle\ProductBundle\Form\Type\ProductVariantType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductVariantTypeExtension extends AbstractTypeExtension
{
    /**
     * @var bool
     */
    private $requireBarcode;

    /**
     * @var bool
     */
    private $requireValidBarcode;

    public function __construct(bool $requireBarcode, bool $requireValidBarcode)
    {
        $this->requireBarcode = $requireBarcode;
        $this->requireValidBarcode = $requireValidBarcode;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $constraints = [];

        if ($this->requireBarcode) {
            $constraints[] = new NotBlank([
                'groups' => ['sylius'],
            ]);
        }

        if ($this->requireValidBarcode) {
            $constraints[] = new Barcode([
                'message' => 'barcode.require_valid',
                'groups' => ['sylius'],
            ]);
        }

        $builder->add('barcode', TextType::class, [
            'required' => $this->requireBarcode,
            'label' => 'loevgaard_sylius_barcode.form.product_variant.barcode',
            'constraints' => $constraints,
        ]);
    }

    public function getExtendedType(): string
    {
        return ProductVariantType::class;
    }
}
