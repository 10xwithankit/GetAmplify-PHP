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



E-commerce function
--------------------
If you are running a B2C or e-commerce company, these functions are essential and shoudl be used. 


### 1. Customer Action
A customer can have following action with products. Replace them from ‘action_names’

1. viewed,
2. purchased,
3. wishlist,
4. add_to_cart,
5. reviewed,
6. shared,
7. completed
8. removed_from_cart


Example
```php  
    $amplifyObject->customerAction(
                            'sandeep@getamplify.com',
                             products => array(
                                         '0' => array(
                                                            productId => 'xxx',
                                                            sku =>  'xxx', //optional
                                                            productTitle => 'xxx', //optional
                                                            price => 'xxx',
                                                            specialPrice => 'xxx', //optional
                                                            status => 'xxx', //optional
                                                            stockAvailability => 'xxx',
                                                            pageURL => 'xxx', //optional
                                                            pictureURL => 'xxx', //optional
                                                            currency => 'xxx',  //optional
                                                            orderId => 'xxx' //compulsory when action_name is purchased
                                                        ),
                                        '1' => array(
                                                            productId => 'xxx',
                                                            sku =>  'xxx', //optional
                                                            productTitle => 'xxx', //optional
                                                            price => 'xxx',
                                                            specialPrice => 'xxx', //optional
                                                            status => 'xxx', //optional
                                                            stockAvailability => 'xxx',
                                                            pageURL => 'xxx', //optional
                                                            pictureURL => 'xxx', //optional
                                                            currency => 'xxx',  //optional
                                                            orderId => 'xxx' //compulsory when action_name is purchased
                                                        )
                                    )
                        );
````




### 2. New Product is Added
You can send information about any new product through this function.

```php  
    $amplifyObject->add(
                            'Email_Address',
                                        array(
                                                'Property_Name'=>'Property_Value',
                                                'Property2_Name'=>'Property2_Value'
                                              )
                          );
````


### 3. Existing Product is Edited

You can send information about any new  through this function.

You can disable a product through this function. You can also change stock availability through this function itself.

```php  
    $amplifyObject->add(
                            'Email_Address',
                                        array(
                                                'Property_Name'=>'Property_Value',
                                                'Property2_Name'=>'Property2_Value'
                                              )
                          );
````


### 4. Order Status Update

Order is automatically created in customer action API. When a product is purchased, orderId is to be passed.

This function helps you updating orderStatus.

```php  
    $amplifyObject->updateOrderStatus( orderId, orderStatus);
````


FAQs
-----
### 1. Can I send an event without sending properties?
Yes, you can. Here's an example.
```php  
    $amplifyObject->event(
                            'sandeep@getamplify.com',
                             array(
                                    'addtocart' => false //property array should be false
                                    )
                        );
````

### 2. Can I send multiple events via a single call?
Yes, you can. Here's an example.
```php  
    $amplifyObject->event(
                            'sandeep@getamplify.com',
                             array(
                                    'add_to_cart' => false,  //Event1
                                    'add_to_WishList' => false  //Event2
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
