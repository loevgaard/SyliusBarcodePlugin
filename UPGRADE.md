# Upgrade from 1.4 to 1.5

1. Update your `ProductVariant` mapping annotations to have `loevgaard_barcode_unique` constraint:

```php
/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_variant",
 *    uniqueConstraints={
 *        @ORM\UniqueConstraint(name="loevgaard_barcode_unique", columns={"barcode", "version"})
 *    }
 * )
 */
class ProductVariant extends BaseProductVariant implements LoevgaardSyliusBarcodePluginProductVariantInterface 
...
```

1. Generate and run database migration

```bash
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

More context - at https://github.com/loevgaard/SyliusBarcodePlugin/pull/12/files
 
# Upgrade from 1.2 to 1.3

Replace `Loevgaard\SyliusBarcodePlugin\Model\BarcodeAwareInterface`
to `Loevgaard\SyliusBarcodePlugin\Model\ProductVariantInterface`
at your `App\Entity\ProductVariant`.

# Upgrade from 1.0 to 1.1

* Prepend the following lines to your `loevgaard_sylius_barcode.yaml` config file (see [this file](tests/Application/config/packages/loevgaard_sylius_barcode.yaml) for an example): 
    
    ```yaml
    imports:
        # ...
        - { resource: "@LoevgaardSyliusBarcodePlugin/Resources/config/app/config.yaml" }
        # ...
    ```
