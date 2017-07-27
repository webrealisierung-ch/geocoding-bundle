#Geocoding Bundle for the Contao Open Source CMS

With this bundle for you can easily calculate the geo position from a given adress, city, place or country over the Google Geocode API with Contao 4.4.*

A Google API key is required. You can generate a API key under the following link: https://developers.google.com/maps/documentation/geocoding/get-api-key

## How to install

###contao/standard-edition

todo

###contao/managed-edition

todo

## Dependencies
- php: ^7.0
- symfony/symfony: ^3.3
- contao/core-bundle: ^4.4


## Usage
You can use the class with the container as follow:
```php
$container=\Contao\System::getContainer();
$Geocoder=container->get('wr.geocoding.geocoder');
$Geocoder->calculate($adress,$country,$apiKey);
```

If the request was successful the geocoder object return the response object from the Google API otherwise it will return NULL.

Alternatively you can access the following properties.

```php
$Geocoder->lat; //return the latitute
$Geocoder->long; //return the longitute
$Geocoder->coords; // return the coordinate in seprated with a coma
$Geocoder->formattedAdress; // return the adress formatted by the Google Geocoding API
$Geocoder->placeId; //return the Google Place ID
$Geocoder->types; //return the Google Geo Position type
$Geocoder->status; //return the Google API status
$Geocoder->geocoderResponse; return the response object form the Google API
```

The bundle is not stable yet. You can use it on your own risk. If you have a feature request or find a bugs or issues feel free submit a issue unter https://github.com/webrealisierung-ch/geocoding-bundle/issues

##Licence

The geocoding bundle is licensed under the terms of the LGPLv3.

##Getting Support

Contact us: [mail@webrealisierung.ch](mailto:mail@webrealisierung.ch)