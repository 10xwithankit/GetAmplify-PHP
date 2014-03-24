GetAmplify SDK for PHP
======================

This SDK allows developers to easily use the GetAmplify API with PHP. This repository contains the open source PHP SDK that allows you to utilize the above on your website. 

You will need your API Key, API Secret and Project ID which you can find in your [Settings](http://getamplify.com/configurations/settings/api-key).

For more information - please refer [Docs](http://getamplify.com/learn/product-guide/) 

Introduction
------------

The GetAmplify PHP SDK provides a few simple ways to to send user events and set user properties.

Installation
------------

Copy the SDK library file to a location within your web application's include path, and include it into any scripts that you wish to make API calls from.

```php
    <?php
        include 'getamplify-sdk.php';
    ?>
````

### Requirements
* PHP >= 5.2.0
* cURL
