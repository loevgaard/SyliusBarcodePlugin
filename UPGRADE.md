 
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
