# Magento 2 module Rental System REST API
``workwiththomas/module-rental-compatible``

The extension create REST API for Magenest_RentalSystem module.

## Main Functionalities

Create rental order with endpoint as this:

```
POST: /V1/thomas-rentalsystem/createOrder
Body payload: 
{
    email: String!, 
    addressId: int!,
    storeId: int!,
    payment: String,
    shipping: String,
    items: [
        {
            sku: String!, 
            rental_price: float!, 
            local_pickup: 1, 
            has_time: 1, 
            qty: int!, 
            rental_from: String!, 
            rental_to: String!, 
            rental_options: {
                "items": [
                    {
                        id: int,
                        value: String
                    },
                    {
                        id: int,
                        value: String
                    },...
                ]
            }
        },
        ....
    ]
}
Response: string - order increment id
```
addressId: is id of recored in table 
Example:

POST: ``/V1/thomas-rentalsystem/createOrder``

```
Body payload: 
{
  "email" : "customer1@gmail.com",
  "storeId" : 1,
  "addressId" : 10,
  "items" : [
    {
      "sku": "car-for-rent-1002",
      "rental_price": 100,
      "local_pickup": 1,
      "has_time": 1,
      "qty": 1,
      "rental_from": "02/14 11:00",
      "rental_to": "02/16 12:00", 
      "rental_options": {
        "items": [
            {
             	"id" : 6,
            	"value" : "5.00_10_2_fixed"
            },
            {
            	"id" : 7,
            	"value" : "11.00_12_3_perhour"
            },
            {
            	"id" : 8,
            	"value" : "20.00_23_4_perday"
            }
        ]
      }
    }
  ]
}
```

## Donation

If this project help you reduce time to develop, you can give me a cup of coffee :) 
[![Buy Me A Coffee](https://raw.githubusercontent.com/thomasnguyen244/resume/update-resume-info/assets/buy-me-a-coffee.png)](https://www.buymeacoffee.com/workwiththomas)

## Installation

- Before install, please purchase and setup module [Rental System Core](https://confluence.izysync.com/display/DOC/Rental+System+Installation+Guide)

### Type 1: Zip file

 - Unzip the zip file in `app/code/Thomas`
 - Enable the module by running `php bin/magento module:enable Thomas_RentalCompatible`
 - Apply database updates by running `php bin/magento setup:upgrade --keep-generated`
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require workwiththomas/module-offline-payments`
 - enable the module by running `php bin/magento module:enable Thomas_RentalCompatible`
 - apply database updates by running `php bin/magento setup:upgrade --keep-generated`
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration
- Config for module on admin > stores > Magenest > Rental System Create Order
- Config option:
+ Enabled
+ Default Payment Method
+ Default Shipping Method

## Specifications


## Attributes


## How to work
- 
