# PHP library for making calls to the API based translation services

By Matthias Noback

[![Build Status](https://travis-ci.org/matthiasnoback/microsoft-translator.png?branch=master)](https://travis-ci.org/matthiasnoback/microsoft-translator) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/matthiasnoback/microsoft-translator/badges/quality-score.png?s=a3230ce4a66715d3a62793da48ba24d8a30ab85d)](https://scrutinizer-ci.com/g/matthiasnoback/microsoft-translator/)

## Supports

* Microsoft
  * [Microsoft Translator V2 API](http://msdn.microsoft.com/en-us/library/ff512419.aspx)
* Google (yet implemented)

## Installation

Using Composer, add to ``composer.json``:

    {
        "require": {
            "matthiasnoback/microsoft-translator": "dev-master"
        }
    }

Then using the Composer binary:

    php composer.phar install

## Usage

You need to register your application at the [Azure DataMarket](https://datamarket.azure.com/developer/applications) and
thereby retrieve a "client id" and a "client secret".

```php
<?php

use MatthiasNoback\Translator;

$translator = new Translator('[YOUR-CLIENT-ID]', '[YOUR-CLIENT-SECRET]');
```

### Optional: enable the access token cache

Each call to the translator service is preceded by a call to Microsoft's OAuth server. Each access token however, may be
cached for 10 minutes, so you should also use the built-in ``AccessTokenCache``:

```php
<?php

use MatthiasNoback\MicrosoftOAuth\AccessTokenCache;
use Doctrine\Common\Cache\ArrayCache;

$cache = new ArrayCache();
$accessTokenCache = new AccessTokenCache($cache);
$accessTokenProvider->setCache($accessTokenCache);
```

The actual cache provider can be anything, as long as it implements the ``Cache`` interface from the Doctrine Common library.

## Making calls

### Translate a string

```php
$translatedString = $translator->translate('This is a test', 'nl', 'en');

// $translatedString will be 'Dit is een test', which is Dutch for...
```

### Translate a string and get multiple translations

```php
$matches = $translator->getTranslations('This is a test', 'nl', 'en');

foreach ($matches as $match) {
    // $match is an instance of MatthiasNoback\MicrosoftTranslator\ApiCall\TranslationMatch
    $degree = $match->getDegree();
    $translatedText = $match->getTranslatedText();
}
```

### Detect the language of a string

```php
$text = 'This is a test';

$detectedLanguage = $translator->detect($text);

// $detectedLanguage will be 'en'
```

### Get a spoken version of a string

```php
$text = 'My name is Matthias';

$spoken = $translator->speak($text, 'en', 'audio/mp3', 'MaxQuality');

// $spoken will be the raw MP3 data, which you can save for instance as a file
```

## Tests

Take a look at the tests to find out what else you can do with the API.

To fully enable the test suite, you need to copy ``phpunit.xml.dist`` to ``phpunit.xml`` and replace the placeholder
values with their real values (i.e. client id, client secret and a location for storing spoken text files).

[![Build Status](https://secure.travis-ci.org/matthiasnoback/microsoft-translator.png)](http://travis-ci.org/matthiasnoback/microsoft-translator)

## Related projects

There is a [MicrosoftTranslatorBundle](https://github.com/matthiasnoback/MicrosoftTranslatorBundle) which makes the Microsoft translator available in a Symfony2 project.

There is also a [MicrosoftTranslatorServiceProvider](https://github.com/matthiasnoback/MicrosoftTranslatorServiceProvider) which registers the Microsoft translator and related services to a Silex application.

## TODO

There are some more calls to be implemented, and also some more tests to be added.
