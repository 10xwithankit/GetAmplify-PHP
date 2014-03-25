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
include 'getamplify-sdk.php';
````

Usage
-----
Before calling any of the common methods you must create an instance of amplify class with valid API key, secret and project ID:

```php  
    $amplifyObject = new Amplify('API_Key','API_Secret','Project_Id');
````

### 1. Identifying a User
A user is identified by its email address.

```php  
    $amplifyObject->identify('Email_Address','Name');
````

Example
```php  
    $amplifyObject->identify('sandeep@getamplify.com','Sandeep');
````

### 2. Sending an event
You can send an event performed by the user with this method. You can also pass properties along with this event. All the existing properties will be updated with the new values passed.

```php  
    $amplifyObject->event(
                    'Email_Address',
                     array(
                            'Event_Name' => array(
                                                    'Property_Name'=>'Property_Value',
                                                    'Property2_Name'=>'Property2_Value'
                                                )
                            )
                        );
````

Example
```php  
    $amplifyObject->event(
                            'sandeep@getamplify.com',
                             array(
                                    'addtocart' => array(
                                                            'product'=>'Samsung Note2',
                                                            'category'=>'Mobile',
                                                            'price'=>'456.78'
                                                        )
                                    )
                        );
````

### 3. Updating User Property
You can use update() method for updating user properties. Any old value of the property will be replaced with new value 
```php  
    $amplifyObject->update(
                            'sandeep@getamplify.com',
                                        array(
                                                'Property_Name'=>'Property_Value',
                                                'Property2_Name'=>'Property2_Value'
                                              )
                          );
````
Example
```php  
    $amplifyObject->update(
                            'Email_Address',
                                        array(
                                                'country'=>'India',
                                                'city'=>'Noida'
                                              )
                          );
````

### 4. Appending User Property
You can use add() method for updating user properties. Any old value of the property will be replaced with new value 
```php  
    $amplifyObject->add(
                            'Email_Address',
                                        array(
                                                'Property_Name'=>'Property_Value',
                                                'Property2_Name'=>'Property2_Value'
                                              )
                          );
````
Example
```php  
    $amplifyObject->add(
                            'sandeep@getamplify.com',
                                        array(
                                                'comments'=>'1',
                                                'shares'=>'1'
                                              )
                          );
````



FAQs
-----
### 1. Can I send an event without sending properties?
Yes, you can. Here's an example.
```php  
    $amplifyObject->event(
                            'sandeep@getamplify.com',
                             array(
                                    'addtocart' => array()
                                    )
                        );
````

### 2. Can I send multiple events in a same call?
Yes, you can. Here's an example.
```php  
    $amplifyObject->event(
                            'sandeep@getamplify.com',
                             array(
                                    'add_to_cart' => array(),
                                    'add_to_WishList' => array()
                                    )
                        );
````

### 3. To identify an user, can I send something else instead of an email address, like UserID?
No, you have to send an email address to identify him as an "Identified User". 
For any user, if email address is not known, it will be treated as Visitor. Though every visitor also had properties and events like Identified User. 


### 4. What if I don't have an email address, how to I call event or add/update properties.
You can use same functions without identifying the user. We create cookie for every visitor and store an unique alias id for that user. This cookie will be read and maintained by getamplify-sdk itself.

Here's and example. (Instead of email addess, blank value is passed)
Example
```php  
    $amplifyObject->event(
                            '',
                             array(
                                    'addtocart' => array(
                                                            'product'=>'Samsung Note2',
                                                            'category'=>'Mobile',
                                                            'price'=>'456.78'
                                                        )
                                    )
                        );
````


### Requirements
* PHP >= 5.2.0
* cURL


Request: Please let us know your feedback and comments. If you have any questions or need a further assistance please contact us at hello@betaout.com.
