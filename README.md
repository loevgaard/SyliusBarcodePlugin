# Sylius Barcode Plugin

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-code-quality]][link-code-quality]

Add barcodes to your products.

## Installation

### Step 1: Download the plugin

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

```bash
$ composer require loevgaard/sylius-barcode-plugin
```

This command requires you to have Composer installed globally, as explained in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.


### Step 2: Enable the plugin

Then, enable the plugin by adding it to the list of registered plugins/bundles
in the `config/bundles.php` file of your project:

```php
<?php
// config/bundles.php

return [
    // ...
    Setono\DoctrineORMBatcherBundle\SetonoDoctrineORMBatcherBundle::class => ['all' => true],
    Loevgaard\SyliusBarcodePlugin\LoevgaardSyliusBarcodePlugin::class => ['all' => true],
    // ...
];
```

Note that adding `SetonoDoctrineORMBatcherBundle` also required.

### Step 3: Configure the plugin

```yaml
# config/packages/loevgaard_sylius_barcode.yaml
imports:
    # ...
    - { resource: "@LoevgaardSyliusBarcodePlugin/Resources/config/app/config.yaml" }
        
loevgaard_sylius_barcode:
    form:
        require: true # If true the barcode field will be required in the product forms
        require_valid: true # If true the barcode must be valid when entered in the product forms

```

### Step 4: Import product variant trait

```php
<?php
// src/Entity/ProductVariant.php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Loevgaard\SyliusBarcodePlugin\Model\ProductVariantInterface as LoevgaardSyliusBarcodePluginProductVariantInterface;
use Loevgaard\SyliusBarcodePlugin\Model\ProductVariantTrait as LoevgaardSyliusBarcodePluginProductVariantTrait;
use Sylius\Component\Core\Model\ProductVariant as BaseProductVariant;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_variant")
 */
class ProductVariant extends BaseProductVariant implements LoevgaardSyliusBarcodePluginProductVariantInterface
{
    use LoevgaardSyliusBarcodePluginProductVariantTrait;
    
    // ...
}
```

**NOTE:** If you haven't extended the `ProductVariant` entity yet, follow the [customization instructions](https://docs.sylius.com/en/1.2/customization/model.html) first because you need to add a bit more configuration:

```
# config/packages/_sylius.yaml
sylius_product:
    resources:
        product_variant:
            classes:
                model: App\Entity\ProductVariant
```

### Step 5: Update your database schema

```bash
$ php bin/console doctrine:migrations:diff
$ php bin/console doctrine:migrations:migrate
```

### Step 6: Add form widgets to twig templates
You need to override the template displaying the product and product variant form and add a `form_row` statement with the barcode:

```twig
{# templates/bundles/SyliusAdminBundle/ProductVariant/Tab/_details.html.twig #}

{# ... #}

<div class="ui segment">
    {{ form_row(form.code) }}
    {{ form_row(form.barcode) }} {# This is the part you should add #}
    <div class="two fields">
        {{ form_row(form.shippingCategory) }}
    </div>
    {{ form_row(form.channelPricings) }}
</div>

{# ... #}
```

```twig
{# templates/bundles/SyliusAdminBundle/Product/Tab/_details.html.twig #}

<div class="ui segment">
    {{ form_row(form.code) }}
    {{ form_row(form.enabled) }}
    {% if product.simple %}
        {{ form_row(form.variant.barcode) }} {# This is the part you should add #}
        {{ form_row(form.variant.onHand) }}
        {{ form_row(form.variant.tracked) }}
        {{ form_row(form.variant.shippingRequired) }}
        {{ form_row(form.variant.version) }}
    {% else %}
        {{ form_row(form.options) }}
        {{ form_row(form.variantSelectionMethod) }}
    {% endif %}

    {# Nothing to see here. #}
    <div class="ui hidden element">
        {% if product.simple %}
            {{ form_row(form.variant.translations) }}
        {% endif %}
        {{ form_row(form.variantSelectionMethod) }}
    </div>
</div>
```

If you haven't overridden the template yet, you can just copy the templates from `vendor/loevgaard/sylius-barcode-plugin/src/Resources/views/SyliusAdminBundle` to `templates/bundles/SyliusAdminBundle/`

### Step 7: Add validator constraint 

Create `config/validator/ProductVariant.xml`:

```xml
<?xml version="1.0" encoding="UTF-8"?>

<constraint-mapping xmlns="http://symfony.com/schema/dic/constraint-mapping"
                    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                    xsi:schemaLocation="http://symfony.com/schema/dic/constraint-mapping http://symfony.com/schema/dic/services/constraint-mapping-1.0.xsd">
    <class name="App\Entity\ProductVariant">
        <constraint name="Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity">
            <option name="fields">barcode</option>
            <option name="message">loevgaard_sylius_barcode.product_variant.barcode.unique</option>
            <option name="groups">sylius</option>
        </constraint>
    </class>
</constraint-mapping>
```

Like it [configured](tests/Application/config/validator/ProductVariant.xml) at example application.

### Step 8: Using asynchronous transport (optional, but recommended)

All commands in this plugin will extend the [CommandInterface](src/Message/Command/CommandInterface.php).
Therefore you can route all commands easily by adding this to your [Messenger config](https://symfony.com/doc/current/messenger.html#routing-messages-to-a-transport):

```yaml
# config/packages/messenger.yaml
framework:
    messenger:
        routing:
            # Route all command messages to the async transport
            # This presumes that you have already set up an 'async' transport
            'Loevgaard\SyliusBarcodePlugin\Message\Command\CommandInterface': async
```

## Usage

Run the check command:

```bash
$ php bin/console loevgaard:barcode:check
```

This will mark all product variant as checked and updated the field `barcodeValid` to either true or false depending on the result of the check.

[ico-version]: https://img.shields.io/packagist/v/loevgaard/sylius-barcode-plugin.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/loevgaard/SyliusBarcodePlugin/master.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/loevgaard/SyliusBarcodePlugin.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/loevgaard/sylius-barcode-plugin
[link-travis]: https://travis-ci.org/loevgaard/SyliusBarcodePlugin
[link-code-quality]: https://scrutinizer-ci.com/g/loevgaard/SyliusBarcodePlugin
