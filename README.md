# Geocoding Bundle for the Contao Open Source CMS

With this bundle you can easily calculate the geo position from a given address, city, place or country over the Google Geocode API with Contao 4.4.*

A Google API key is required. You can generate a API key under the following link: https://developers.google.com/maps/documentation/geocoding/get-api-key

## Attention

This bundle is currently under development. You can use it at your own risk! A stable version will be available soon. Of course you can submit issues and feature requests on the [repository issue section](https://github.com/webrealisierung-ch/geocoding-bundle/issues). Thx! 

## How to install

### Contao Standard Edition

Run in your project folder the following Composer command to add the Geocoding Bundle to your project:

```console
    ./composer require wr/geocoding-bundle
```

Add the Bundle to `app/AppKernel.php` bundles array after all the Contao bundles:

```php
public function registerBundles()
    {
        $bundles = [
            .....    
            new Wr\GeocodingBundle\WrGeocodingBundle() //Add this line.
        ];

        ....
        
        return $bundles;
    }
```

Clear the cache and warmup the cache with the following two commands:

```console
    ./bin/console cache:clear --no-warmup --env=prod
    ./bin/console cache:warmup  --env=prod
```

Go to the install tool and update the database. Then login into the back end.

### Contao Managed Edition

**Without the awesome Contao Manager**

Run in your project folder the following Composer command to add the geocoding Bundle to your project:

```console
    composer require wr/geocoding-bundle
```

Clear the cache and warmup the cache with the following two commands:

```console
    vendor/bin/contao-console cache:clear --no-warmup
    vendor/bin/contao-console cache:warmup
```

Go to the install tool and update the database. Then login into the back end.

**With the awesome Contao Manager**

1. Search in the Contao Manager search bar the bundle `wr/geocoding-bundle` and click on the install button.
2. Go to the install tool and update the database. Then login into the back end.


## Dependencies

- `php: ^7.0`
- `symfony/symfony: ^3.3`
- `contao/core-bundle: ^4.4`


## Usage
You can use the class with the container as follow:
```php
$container=\Contao\System::getContainer();
$Geocoder=container->get('wr.geocoding.geocoder');
$Geocoder->calculate($address,$country,$apiKey);
```

If the request was successful the geocoder object return the response object from the Google API otherwise it will return NULL.

Alternatively you can access the following properties.

```php
$Geocoder->lat; //return the latitute
$Geocoder->lng; //return the longitute
$Geocoder->coords; // return the coordinate in seprated with a coma
$Geocoder->formattedAddress; // return the address formatted by the Google Geocoding API
$Geocoder->placeId; //return the Google Place ID
$Geocoder->types; //return the Google Geo Position type
$Geocoder->status; //return the Google API status
$Geocoder->geocoderResponse; //return the response object form the Google API
```

## Licence

The geocoding bundle is published under the LGPLv3.

## Documentation

Unfortunately, at the moment there is no documentation available. But we will fix this as soon as there is a stable version.
 
 ## Contact/Support
 
 For further information feel free and get in contact with us: mail@webrealisierung.ch
 
 ## Donation
 
 If you like our work feel free to donate.
 
 There are many ways to donate to the project. The following list contains some possibilities:
 
 - Contribute your code over pull requests.
 - Test, test, test and feedback.
 - Submit features or issues.
 - Tell us a joke.
 - [![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=EHB7BYWLMPV7Y) You know that every coffee counts while coding:-)
 

