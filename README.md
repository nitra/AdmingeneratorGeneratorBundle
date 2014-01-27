# Symfony2 Admin Generator
---------------------------------------

[![KnpBundles Badge](http://knpbundles.com/symfony2admingenerator/AdmingeneratorGeneratorBundle/badge-short)](http://knpbundles.com/symfony2admingenerator/AdmingeneratorGeneratorBundle)
![project status](http://stillmaintained.com/cedriclombardot/AdmingeneratorGeneratorBundle.png) 
[![build status](https://secure.travis-ci.org/symfony2admingenerator/AdmingeneratorGeneratorBundle.png)](http://travis-ci.org/symfony2admingenerator/AdmingeneratorGeneratorBundle)
[![Latest Stable Version](https://poser.pugx.org/cedriclombardot/admingenerator-generator-bundle/v/stable.png)](https://packagist.org/packages/cedriclombardot/admingenerator-generator-bundle)
[![Total Downloads](https://poser.pugx.org/cedriclombardot/admingenerator-generator-bundle/downloads.png)](https://packagist.org/packages/cedriclombardot/admingenerator-generator-bundle)

### The Real Missing Admin Generator for Symfony2!
This package is a Symfony2 Admin Generator based on YAML configuration and Twig templating. It's inspired by [fzaninotto/Doctrine2ActiveRecord](https://github.com/fzaninotto/Doctrine2ActiveRecord).

### Follow us on Twitter!

Don't miss any updates from **Symfony2 Admin Generator**! Join Twitter today and [follow us](https://twitter.com/sf2admgen)!

## Features:

* Generate Views and Controllers for Models with one command
* Configure all options in one (per model) YAML file
* Includes standard actions: create/edit, show, delete, list/nestedset tree list
* Flexible and extendable: you can *easily* add or overwrite almost everything!
* Supports most popular model managers: **Doctrine ORM**, **Doctrine ODM** and **Propel**
* Introduces nested forms: create/edit object and all it's associated objects in one form!
* Manage relations one to one, one to many, many to one and **many to many**
* Fully translatable: all field elements (labels, placeholders, helpers), all widgets, actions, error messages and titles
* **List features:** sortable, paginated, filters, batch actions, scopes
* **Nestedset tree list features:** drag&drop to manage your tree
* **New/Edit featues:** fieldsets, tabbable, cool widgets for *collection, file upload, date and entity* fields
* Translated into DE, **EN (default)**, ES, FA, FR, GR, IT, JA, NL, PL, PT, RO, RU, SL, TR, UK (you can easily contribute to add your own)
* Credentials for actions, columns and form fields
* Complete admin design based on [twitter bootstrap](http://twitter.github.com/bootstrap/) *(see next section)*
* ... and more!

## This bundle in pictures

![Preview of list](https://github.com/symfony2admingenerator/AdmingeneratorGeneratorBundle/raw/master/Resources/preview/list-preview.png)

![Preview of edit](https://github.com/symfony2admingenerator/AdmingeneratorGeneratorBundle/raw/master/Resources/preview/edit-preview.png)

![Preview of dashboard](https://github.com/symfony2admingenerator/AdmingeneratorGeneratorBundle/raw/master/Resources/preview/dashboard-welcome-preview.png)

# Important note

Documentation is currently being rewritten. Old documentation can be found in:

* [Resources/old-doc](https://github.com/symfony2admingenerator/AdmingeneratorGeneratorBundle/tree/master/Resources/old-doc) directory
* [symfony2admingenerator.org](http://symfony2admingenerator.org) website
* some new features configuration can be found in github issues/PR comments

Sorry for inconvenience, we will fix that as soon as possible!

## Installation

All the installation instructions are located in [documentation](https://github.com/symfony2admingenerator/AdmingeneratorGeneratorBundle/blob/master/Resources/doc/documentation.md#installation).

## Documentation

The documentation for this bundle is located in `Resources/doc` directory. Start by reading [Table of contents](https://github.com/symfony2admingenerator/AdmingeneratorGeneratorBundle/blob/master/Resources/doc/documentation.md#table-of-contents).

### Translations

If you wish to use default texts provided in this bundle, you have to make
sure you have translator enabled in your config.

``` yaml
# app/config/config.yml

framework:
    translator: ~
```

For more information about translations, check [Symfony documentation](http://symfony.com/doc/current/book/translation.html).

## Installation

Installation is a 3 step process:

1. Download NitraThemeBundle using composer
2. Enable the Bundle
3. Configure the NitraThemeBundle

### Step 1: Download NitraThemeBundle using composer

Add NitraThemeBundle in your composer.json:

```js
{
    "require": {
        "nitra/admingenerator-generator-bundle": "2.3.*@dev"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update nitra/admingenerator-generator-bundle
```
    
Composer will install the bundle to your project's `vendor/nitra` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Knp\Bundle\MenuBundle\KnpMenuBundle(),
        new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
        new Admingenerator\GeneratorBundle\AdmingeneratorGeneratorBundle(),
        new Millwright\MenuBundle\MillwrightMenuBundle(),
		new Millwright\ConfigurationBundle\MillwrightConfigurationBundle(),
		new FOS\UserBundle\FOSUserBundle(),
    );
}
```
### Step 3: Configure 

Add the following configuration to your `config.yml` file according to which type
of datastore you are using.

``` yaml
# app/config/config.yml
imports:
    - { resource: menu.yml }
    - { resource: ../../vendor/nitra/doctrine-behaviors/config/orm-services.yml }


# Assetic Configuration
assetic:
    debug:          %kernel.debug%
    use_controller: false
    bundles:        [ AdmingeneratorGeneratorBundle ]
    #java: /usr/bin/java
    filters:
        cssrewrite: ~
        lessphp: ~

# Doctrine Configuration
doctrine:
    orm:
        filters:
            softdeleteable:
                class: Admingenerator\GeneratorBundle\Filter\SoftDeleteableFilter
                enabled: true
        hydrators:
            KeyPair: Admingenerator\GeneratorBundle\Hydrators\KeyPairHydrator      
            
# FOS Configuration
fos_user:
    db_driver: orm # other valid values are 'mongodb'
    firewall_name: main
    user_class: Nitra\NitraThemeBundle\Entity\User
	
# Admingenerator Configuration
admingenerator_generator:
    base_admin_template: ::base_admin.html.twig
    use_doctrine_orm: true
    stylesheets: []
    twig:
        use_localized_date: true
        date_format: 'Y-M-d'
        localized_date_format: 'full'
        localized_datetime_format: 'medium'
        datetime_format: 'Y-m-d H:i'  
        number_format:
            decimal: 2
            decimal_point: ','
            thousand_separator: ' '
			
# Add blameable listener
parameters:
    knp.doctrine_behaviors.blameable_listener.user_entity: Nitra\NitraThemeBundle\Entity\User			
```