# Yalidine-Dz-Laravel-Api

laravel package For Yalidine Api Integrations.

## Installation 
1. in your composer.json, update:
```json
"minimum-stability": "dev"
```

2. Using your CLI, install the package via `composer` as follows:

```bash
composer require sebbahnouri/yalidine
```

3. The package service provider will be automatically loaded by Laravel once installed. You can also register the package service provider manually in the `providers` array within your `config.php`:

```php
"providers" => [
    ..
    Sebbahnouri\Yalidine\Providers\YaledineServiceProvider::class
]
```
4. Publish the package configuration file:
```bash
php artisan vendor:publish --tag=Yale-config
```

5. Inject your Yalidin credentials to your `.env` file:

```bash
API_ID=******
API_TOKEN=*******
```

If you don't have any, make sure you obtain them from this [Yaldine Official Website](https://www.yalidine.com/).


## Usage
1. invoke the singleton

```php
use Sebbahnouri\Yalidine\Yalidine;

$yalidine = app(Yalidine::class);

# usage example
$yalidine->method($params);
```

## Available methods
### Retrieve the parcels

```php
$yalidine->retrieveParcels()  # for all the parcels
```

or

```php
$trackings = ['yal-205643','yal-454FU'];

$yalidine->retrieveParcels($trackings);
```

### Retrieve the Histories
to get all histories

```php
$yalidine->deliveredParcels()
```

Or, per status as follows:

```php
$status = 'Livré';
$yalidine->deliveredParcels($status)
```

### Create the parcels

```php
$parcels = array( // the array that contains all the parcels
     array ( // first parcel
       "order_id"=>"MyFirstOrder",
             "from_wilaya_name"=>"Batna",
             "firstname"=>"Brahim",
             "familyname"=>"Mohamed",
             "contact_phone"=>"0123456789,",
             "address"=>"Cité Kaidi",
             "to_commune_name"=>"Bordj El Kiffan",
             "to_wilaya_name"=>"Alger",
             "product_list"=>"Presse à café",
             "price"=>3000,
             "height"=> 10,
             "width" => 20,
             "length" => 30,
             "weight" => 6,
             "freeshipping"=> true,
             "is_stopdesk"=> true,
             "stopdesk_id" => 163001,
             "has_exchange"=> 0,
             "product_to_collect" => null
     ),
     array ( // second parcel
     "order_id" =>"MySecondOrder",
             "from_wilaya_name"=>"Batna",
             "firstname"=>"رفيدة",
             "familyname"=>"بن مهيدي",
             "contact_phone"=>"0123456789",
             "address"=>"حي الياسمين",
             "to_commune_name"=>"Ouled Fayet",
             "to_wilaya_name"=>"Alger",
             "product_list"=>"كتب الطبخ",
             "price"=>2400,
             "height" => 10,
             "width" => 20,
             "length" => 30,
             "weight" => 6,
             "freeshipping"=>0,
             "is_stopdesk"=>0,
             "has_exchange"=> false,
     ),
     array ( // third parcel
         ...
     ),
     array( // Add as much as you want ..
         ...
     )
);

$yalidine->createParcels($parcels);
```

### Delete the parcels

```php
$trackings = ['yal-205643','yal-454FU'];

$yalidine->deleteParcels($trackings);
```

### Retrieve the delivery fees

Retrieve results for certain wilayas:
```php
$wilayas_id = ['13','14'];
$yalidine->retrieveDeliveryfees($wilaya_ids);
```

Or for all:

```php
$yalidine->retrieveDeliveryfees();
```