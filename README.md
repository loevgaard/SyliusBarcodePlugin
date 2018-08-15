# Sylius Barcode Plugin

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-code-quality]][link-code-quality]

Add barcodes to your products

## Installation

### Step 1: Download the plugin

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

```bash
$ composer require loevgaard/sylius-barcode-plugin
```

This command requires you to have Composer installed globally, as explained in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.


### Step 2: Enable the plugin

Then, enable the plugin by adding it to the list of registered plugins/bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

use Sylius\Bundle\CoreBundle\Application\Kernel;

final class AppKernel extends Kernel
{
    public function registerBundles(): array
    {
        return array_merge(parent::registerBundles(), [
            // ...
            new \Loevgaard\SyliusBarcodePlugin\LoevgaardSyliusBarcodePlugin(),
            // ...
        ]);
    }
    
    // ...
}
```

### Step 3: Configure the plugin

```yaml
# app/config/config.yml

loevgaard_sylius_barcode:
    require_in_form: true # If true the barcode field will be required in the product variant form

```

In `src/AppBundle/Resources/config/doctrine/Product.orm.xml`:
```xml
<?xml version="1.0" encoding="UTF-8"?>

<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                                      http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <mapped-superclass name="AppBundle\Entity\ProductVariant" table="sylius_product_variant">
        <field name="barcode" column="barcode" type="string" nullable="true" />
        <field name="barcodeChecked" column="barcode_checked" type="datetime" nullable="true" />
        <field name="barcodeValid" column="barcode_valid" type="boolean" nullable="true" />
    </mapped-superclass>

</doctrine-mapping>
```

### Step 4: Import product variant trait

```php
<?php
// src/AppBundle/Entity/ProductVariant.php

declare(strict_types=1);

namespace AppBundle\Entity;

use Loevgaard\SyliusBarcodePlugin\Entity\BarcodeAwareInterface;
use Loevgaard\SyliusBarcodePlugin\Entity\ProductVariantTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;

class ProductVariant extends BaseProduct implements BarcodeAwareInterface
{
    use ProductVariantTrait;
    
    // ...
}
```

**NOTE:** If you haven't extended the `ProductVariant` entity yet, follow the [customization instructions](https://docs.sylius.com/en/1.2/customization/model.html) first because you need to add a bit more configuration.

### Step 5: Update your database schema
```bash
$ php bin/console doctrine:schema:update --force
```

or use [Doctrine Migrations](https://symfony.com/doc/master/bundles/DoctrineMigrationsBundle/index.html):

```bash
$ php bin/console doctrine:migrations:diff
$ php bin/console doctrine:migrations:migrate
```

### Step 6: Add form widgets to twig templates
You need to override the template displaying the product and product variant form and add a `form_row` statement with the barcode:

```twig
{# app/Resources/SyliusAdminBundle/views/ProductVariant/Tab/_details.html.twig #}

{# ... #}

<div class="ui segment">
    <h4 class="ui dividing header">{{ 'sylius.ui.properties'|trans }}</h4>
    {{ form_row(form.barcode) }} {# This is the part you should add #}
    {{ form_row(form.height) }}
    {{ form_row(form.width) }}
    {{ form_row(form.depth) }}
    {{ form_row(form.weight) }}
</div>

{# ... #}
```

If you haven't overridden the template yet, you can just copy the template from `vendor/loevgaard/sylius-barcode-plugin/src/Resources/views/SyliusAdminBundle` to `app/Resources/SyliusAdminBundle/views/`

[ico-version]: https://img.shields.io/packagist/v/loevgaard/sylius-barcode-plugin.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/loevgaard/SyliusBarcodePlugin/master.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/loevgaard/SyliusBarcodePlugin.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/loevgaard/sylius-barcode-plugin
[link-travis]: https://travis-ci.org/loevgaard/SyliusBarcodePlugin
[link-code-quality]: https://scrutinizer-ci.com/g/loevgaard/SyliusBarcodePlugin