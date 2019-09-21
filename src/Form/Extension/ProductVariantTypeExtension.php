<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Form\Extension;

use Loevgaard\SyliusBarcodePlugin\Validator\Constraint\Barcode;
use Sylius\Bundle\ProductBundle\Form\Type\ProductVariantType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductVariantTypeExtension extends AbstractTypeExtension
{
    /** @var bool */
    private $requireBarcode;

    /** @var bool */
    private $requireValidBarcode;

    /** @var array */
    private $validationGroups;

    public function __construct(bool $requireBarcode, bool $requireValidBarcode, array $validationGroups = [])
    {
        $this->requireBarcode = $requireBarcode;
        $this->requireValidBarcode = $requireValidBarcode;

        // todo in v2 of this plugin remove this check and remove the default value of $validationGroups
        if (count($validationGroups) === 0) {
            $validationGroups[] = 'sylius';
        }

        $this->validationGroups = $validationGroups;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $constraints = [];

        if ($this->requireBarcode) {
            $constraints[] = new NotBlank([
                'message' => 'loevgaard_sylius_barcode.product_variant.barcode.not_blank',
                'groups' => $this->validationGroups,
            ]);
        }

        if ($this->requireValidBarcode) {
            $constraints[] = new Barcode([
                'message' => 'loevgaard_sylius_barcode.product_variant.barcode.valid',
                'groups' => $this->validationGroups,
            ]);
        }

        $builder->add('barcode', TextType::class, [
            'required' => $this->requireBarcode,
            'label' => 'loevgaard_sylius_barcode.form.product_variant.barcode',
            'constraints' => $constraints,
        ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [ProductVariantType::class];
    }
}
