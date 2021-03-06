<img src="Dropoff-Logo-Cropped.png" alt="Drawing" style="width: 200px;"/>


# Brawndo PHP Client

This is the 3rd party dropoff php client for creating and viewing orders and adding tips.

* **For Javascript documentation go [HERE](https://github.com/dropoff-co/com.dropoff.service.brawndo.client.js "Javascript")**
* **For Ruby documentation go [HERE](https://github.com/dropoff-co/com.dropoff.service.brawndo.client.ruby "Ruby")**
* **For GO documentation go [HERE](https://github.com/dropoff-co/com.dropoff.service.brawndo.client.go "GO")**
* **For C# documentation go [HERE](https://github.com/dropoff-co/com.dropoff.service.brawndo.client.dotnetcore "C#")**


# Table of Contents
  + [Client Info](#client)
    - [Configuration](#configuration)
    - [Getting Your Account Info](#client_info)
    - [Enterprise Managed Clients](#managed_clients)
    - [Order Properties](#order_properties)
    - [Order Items](#order_items)
    - [Getting Pricing Estimates](#estimates)
    - [Placing an Order](#placing)
    - [Cancelling an Order](#cancel)
    - [Getting a Specific Order](#specific)
    - [Getting a Page of Order](#page)
  + [Signature Image URL](#signature)
  + [Tips](#tips)  
    - [Creating](#tip_create)
    - [Deleting](#tip_delete)
    - [Reading](#tip_read)
  + [Webhook Info](#webhook)
    - [Webhook Backoff Algorithm](#backoff)
    - [Webhook Events](#events)
    - [Managed Client Events](#managed_client_events)
  + [Order Simulation](#simulation)

## Using the client <a id="client"></a>

### Configuration <a id="configuration"></a>

You will have to configure the brawndo instance via the constructor.

	$public_key = 'b123bebbce97f1b06382095c3580d1be4417dbe376956ae9';
	$private_key = '87150f36c5de06fdf9bf775e8a7a1d0248de9af3d8930da0';
	$api_url = 'https://sandbox-brawndo.dropoff.com/v1';
	$host = 'sandbox-brawndo.dropoff.com';
	$brawndo = new \Dropoff\Brawndo($public_key, $private_key, $api_url, $host);

---
* **api_url** - the url of the brawndo api.  This field is required.
* **host** - the api host.  This field is required.
* **public_key** - the public key of the user that will be using the client.  This field is required.
* **private_key** - the private key of the user that will be using the client.

---

### Getting Your Client Information <a id="client_info"></a>

If you want to know your client id and name you can access this information via the info call.

If you are an enterprise client user, then this call will return all of the accounts that you are allowed to manage with your current account.

    $result = $brawndo->info();
    
A response will look like this:

    array(3) {
      ["success"]=>
      bool(true)
      ["timestamp"]=>
      string(20) "2017-01-26T14:42:48Z"
      ["data"]=>
      array(3) {
        ["user"]=>
        array(3) {
          ["first_name"]=>
          string(6) "Global"
          ["last_name"]=>
          string(3) "Guy"
          ["id"]=>
          string(13) "1111111111110"
        }
        ["client"]=>
        array(2) {
          ["company_name"]=>
          string(19) "EnterpriseCo Global"
          ["id"]=>
          string(13) "1111111111110"
        }
        ["managed_clients"]=>
        array(4) {
          ["level"]=>
          int(0)
          ["company_name"]=>
          string(19) "EnterpriseCo Global"
          ["id"]=>
          string(13) "1111111111110"
          ["children"]=>
          array(2) {
            [0]=>
            array(4) {
              ["company_name"]=>
              string(19) "EnterpriseCo Europe"
              ["level"]=>
              int(1)
              ["id"]=>
              string(13) "1111111111112"
              ["children"]=>
              array(3) {
                [0]=>
                array(4) {
                  ["company_name"]=>
                  string(18) "EnterpriseCo Paris"
                  ["level"]=>
                  int(2)
                  ["id"]=>
                  string(13) "1111111111111"
                  ["children"]=>
                  array(0) {
                  }
                }
                [1]=>
                array(4) {
                  ["company_name"]=>
                  string(19) "EnterpriseCo London"
                  ["level"]=>
                  int(2)
                  ["id"]=>
                  string(13) "1111111111113"
                  ["children"]=>
                  array(0) {
                  }
                }
                [2]=>
                array(4) {
                  ["company_name"]=>
                  string(18) "EnterpriseCo Milan"
                  ["level"]=>
                  int(2)
                  ["id"]=>
                  string(13) "1111111111114"
                  ["children"]=>
                  array(0) {
                  }
                }
              }
            }
            [2]=>
            array(4) {
              ["company_name"]=>
              string(15) "EnterpriseCo NA"
              ["level"]=>
              int(1)
              ["id"]=>
              string(13) "1111111111115"
              ["children"]=>
              array(3) {
                [0]=>
                array(4) {
                  ["company_name"]=>
                  string(20) "EnterpriseCo Chicago"
                  ["level"]=>
                  int(2)
                  ["id"]=>
                  string(13) "1111111111116"
                  ["children"]=>
                  array(0) {
                  }
                }
                [1]=>
                array(4) {
                  ["company_name"]=>
                  string(21) "EnterpriseCo New York"
                  ["level"]=>
                  int(2)
                  ["id"]=>
                  string(13) "1111111111117"
                  ["children"]=>
                  array(0) {
                  }
                }
                [2]=>
                array(4) {
                  ["company_name"]=>
                  string(24) "EnterpriseCo Los Angeles"
                  ["level"]=>
                  int(2)
                  ["id"]=>
                  string(13) "1111111111118"
                  ["children"]=>
                  array(0) {
                  }
                }
              }
            }
          }
        }
      }
    }
    
The main sections in data are user, client, and managed_clients.  

The user info shows basic information about the Dropoff user that the used keys represent.

The client info shows basic information about the Dropoff Client that the user belongs to who's keys are being used.

The managed_clients info shows a hierarchical structure of all clients that can be managed by the user who's keys are being used.

### Enterprise Managed Clients  <a id="managed_clients"></a>

In the above info example you see that keys for a user in an enterprise client are being used.  It has clients that can be managed as it's descendants.

The hierarchy looks something like this:


        EnterpriseCo Global (1111111111110)
        ├─ EnterpriseCo Europe (1111111111112)
        │  ├─ EnterpriseCo Paris (1111111111111)
        │  ├─ EnterpriseCo London (1111111111113)
        │  └─ EnterpriseCo Milan (1111111111114)
        └─ EnterpriseCo NA (1111111111115)
           ├─ EnterpriseCo Chicago (1111111111116)
           ├─ EnterpriseCo New York (1111111111117)
           └─ EnterpriseCo Los Angeles (1111111111118)


Let's say I was using keys for a user in **EnterpriseCo Europe**, then the returned hierarchy would be:

        EnterpriseCo Europe (1111111111112)
        ├─ EnterpriseCo Paris (1111111111111)
        ├─ EnterpriseCo London (1111111111113)
        └─ EnterpriseCo Milan (1111111111114)
        
Note that You can no longer see the **EnterpriseCo Global** ancestor and anything descending and including **EnterpriseCo NA**.


So what does it mean to manage an enterprise client?  This means that you can:

- Get estimates for that client.
- Place an order for that client.
- Cancel an order for that client.
- View existing orders placed for that client.
- Create, update, and delete tips for orders placed for that client.

All you have to do is specify the id of the client that you want to act on.  So if wanted to place orders for **EnterpriseCo Paris** I would make sure to include that clients id: "1111111111111".

The following api documentation will show how to do this.

### Order Properties <a id="order_properties"></a>

Depending on your client, you may have the option to add properties to your order.  In order to determine whether or not your client has properties, you can make a call the **AvailableProperties** method.  It will return all properties that can be applied to your orders during creation.

    $company_id = NULL //optional
    $result = $brawndo->order->properties($company_id);

	
If you include a **company_id** you will retrieve that company's properties only if your account credentials are managing that account.

An example of a successful response will look like this:

	array(4) {
	  ["data"]=>
		  array(3) {
		    [0]=>
		    array(6) {
		      ["id"]=>
		      int(1)
		      ["label"]=>
		      string(13) "Leave at Door"
		      ["description"]=>
		      string(66) "If recipient is not at home or at office, leave order at the door."
		      ["price_adjustment"]=>
		      int(0)
		      ["conflicts"]=>
		      array(1) {
		        [0]=>
		        int(2)
		      }
		      ["requires"]=>
		      array(0) {
		      }
		    }
		    [1]=>
		    array(6) {
		      ["id"]=>
		      int(2)
		      ["label"]=>
		      string(18) "Signature Required"
		      ["description"]=>
		      string(37) "Signature is required for this order."
		      ["price_adjustment"]=>
		      int(0)
		      ["conflicts"]=>
		      array(1) {
		        [0]=>
		        int(1)
		      }
		      ["requires"]=>
		      array(0) {
		      }
		    }
		    [2]=>
		    array(6) {
		      ["id"]=>
		      int(3)
		      ["label"]=>
		      string(12) "Legal Filing"
		      ["description"]=>
		      string(85) "This order is a legal filing at the court house. Please read order remarks carefully."
		      ["price_adjustment"]=>
		      int(5.50)
		      ["conflicts"]=>
		      array(0) {
		      }
		      ["requires"]=>
		      array(1) {
		        [0]=>
		        int(2)
		      }
		      }
		    }
		  }
	  ["count"]=>
	  int(3)
	  ["total"]=>
	  int(3)
	  ["success"]=>
	  bool(true)
	}

- **id** - the id of the property, you will use this value if you want to add the property to an order you are creating
- **label** - a simple description of the property.
- **description** - more details about the property.
- **price_adjustment** - a number that describes any additional charges that the property will require.
- **conflicts** - an array of other property ids that cannot be included in an order when this property is set.  In the above response you cannot set both "Leave at Door" and "Signature Required".
- **requires** - an array of other property ids that must be included in an order when this property is set.  In the above response, when "Legal Filing" is set on an order, then "Signature Required" should be set as well.

### Order Items <a id="order_items"></a>
Depending on your client, you may have the ability to add items to an order.  In order to determine if you can add items and which properties are disabled, optional, or required you can make a request to the **items** function.  It will return the order items configuration for the specified client.

```php
$company_id = NULL; //optional
$result = $brawndo->order->items($company_id);
```

If you include the **company_id** you will retrieve that company's properties only if your account credentials are managing that account.

Note that the response contains some data that won't be necessary, the fields that will be needed to know how items are configured for your client are **order_item_enabled** and any field that contains **\_allow\_**.  These fields will be of 3 values, 0 - disabled, 1 - optional, or 2 - required.  If line items are optional and you include an item when creating an order, you must include all required **\_allow\_** fields.

In the below output, line items are optional.  The following are required fields: sku, person_name, description, dimensions, and temperature.  Optional fields are: weight and quantity.  Disabled fields are container and price.

An example of a successful response will look like this:
```
array(3) {
  ["data"]=>
  array(17) {
    ["order_item_temp_refrigerated_max_value"]=>
    int(42)
    ["order_item_allow_sku"]=>
    int(2)
    ["company_id"]=>
    string(32) "7df2b0bdb418157609c0d5766fb7fb12"
    ["order_item_allow_weight"]=>
    int(1)
    ["order_item_enabled"]=>
    int(1)
    ["order_item_allow_person_name"]=>
    int(2)
    ["order_item_allow_quantity"]=>
    int(1)
    ["order_item_allow_description"]=>
    int(2)
    ["order_item_person_name_label"]=>
    string(9) "Man/Woman"
    ["order_item_allow_dimensions"]=>
    int(2)
    ["order_item_allow_container"]=>
    int(0)
    ["order_item_temp_frozen_max_value"]=>
    int(2)
    ["order_item_temp_unit"]=>
    string(1) "F"
    ["order_item_allow_price"]=>
    int(0)
    ["order_item_allow_temperature"]=>
    int(2)
    ["order_item_temp_frozen_min_value"]=>
    int(0)
    ["order_item_temp_refrigerated_min_value"]=>
    int(40)
  }
  ["success"]=>
  bool(true)
  ["timestamp"]=>
  string(20) "2018-12-19T21:01:41Z"
}
```

- **order_item_temp_refrigerated_max_value** - The max temperature a refrigerated item can reach.
- **order_item_allow_sku** - Signifies whether the sku is an optional, required, or disabled field for a line item
- **company_id** - Company identifier for the order items configuration
- **order_item_allow_weight** - Signifies whether item weight is an optional, required, or disabled field for a line item
- **order_item_enabled** - Signifies line items are optional, required, or disabled.
- **order_item_allow_person_name** - Signifies whether person_name is an optional, required, or disabled field for a line item
- **order_item_allow_quantity** - Signifies whether quantity of an item is an optional, required, or disabled field for a line item
- **order_item_allow_description** - Signifes whether a description is optional, required, or disabled for a line item
- **order_item_person_name_label** - A label to be displayed when showing a person_name
- **order_item_allow_dimensions** -  Signifies whether dimensions are optional, required, or disabled for a line item. **Note** - If diemensions are used for an item, you must include width, height, depth, and units
- **order_item_allow_container** - Signifies whether a container type is optional, required, or disabled for a line item.
- **order_item_temp_frozen_max_value** - The max temperature a frozen item can reach
- **order_item_temp_unit** - The units that max/min temperatures represent. F or C
- **order_item_allow_price** - Signifies whether a price is optional, required, or disabled for a line item
- **order_item_allow_temperature** - Signifies whether a temperature type is optional, required, or disabled for a line item.  **Note** - Frozen, refrigerated, etc.
- **order_item_temp_frozen_min_value** - The minimum temperature a frozen item can reach
- **order_item_temp_refrigerated_min_value** - The minimum temperature a refrigerated item can reach

### Getting Pricing Estimates <a id="estimates"></a>

Before you place an order you will first want to estimate the distance, eta, and cost for the delivery.  The client provides a **getEstimate** function for this operation.

    $origin = '117 San Jacinto Blvd, Austin, TX 78701, United States';  // required
    $destination = '800 Brazos Street, Austin, TX 78701, United States'; // required
    $utc_offset = '-06:00'; // required
    $ready_timestamp = 1425578400; // optional
    $company_id = '1111111111111'; // optional

---
* **origin** - the origin (aka the pickup location) of the order.  Required.
* **destination** - the destination (aka the delivery location) of the order.  Required.
* **utc_offset** - the utc offset of the timezone where the order is taking place.  Required.
* **ready_timestamp** - the unix timestamp (in seconds) representing when the order is ready to be picked up.  If not set we assume immediate availability for pickup.
* **company_id** - if you are using brawndo as an enterprise client that manages other dropoff clients you can specify the managed client id who's estimate you want here.  This is optional and only works for enterprise clients.
---


	$result = $brawndo->estimate('800 Brazos St, Austin, TX 78701', '2517 Thornton Rd, Austin, TX 78704', date('P'), time(), $company_id);


An example of a successful result will look like this:

	array(3) {
	  ["data"]=>
	  array(6) {
	    ["ETA"]=>
	    string(6) "1023.1"
	    ["Distance"]=>
	    string(4) "3.79"
	    ["asap"]=>
	    array(3) {
	      ["ETA"]=>
	      string(6) "1023.1"
	      ["Distance"]=>
	      string(4) "3.79"
	      ["Price"]=>
	      string(4) "2.06"
	    }
	    ["two_hr"]=>
	    array(3) {
	      ["ETA"]=>
	      string(6) "1023.1"
	      ["Distance"]=>
	      string(4) "3.79"
	      ["Price"]=>
	      string(5) "17.56"
	    }
	    ["four_hr"]=>
	    array(3) {
	      ["ETA"]=>
	      string(6) "1023.1"
	      ["Distance"]=>
	      string(4) "3.79"
	      ["Price"]=>
	      string(5) "15.96"
	    }
	    ["all_day"]=>
	    array(3) {
	      ["ETA"]=>
	      string(6) "1023.1"
	      ["Distance"]=>
	      string(4) "3.79"
	      ["Price"]=>
	      string(5) "13.96"
	    }
	    ["service_type"]=>
	    string(8) "standard"
	  }
	  ["success"]=>
	  bool(true)
	  ["timestamp"]=>
	  string(25) "2016-02-26T14:05:25+00:00"
	}

---
* **data** - contain the pricing information for the allowed delivery window based on the given ready time, so you will not always see every option.
* **Distance** - the distance from the origin to the destination.
* **ETA** - the estimated time (in seconds) it will take to go from the origin to the destination.
* **From** - the origin zip code.  Only available if you have a zip to zip rate card configured.
* **To** - the destination zip code.  Only available if you have a zip to zip rate card configured.
* **asap** - the pricing for an order that needs to delivered within an hour of the ready time.
* **two_hr** - the pricing for an order that needs to delivered within two hours of the ready time.
* **four_hr** - the pricing for an order that needs to delivered within four hours of the ready time.
* **all_day** - the pricing for an order that needs to delivered by end of business on a weekday.
* **service_type** - The service type for pricing, could be standard, holiday, or after_hr.

---
### Placing an order <a id="placing"></a>

Given a successful estimate call, and a window that you like, then the order can be placed.  An order requires origin information, destination information, and specifics about the order.

#### Origin and Destination data.

The origin and destination contain information regarding the addresses in the order.

	$destination = array(
	    'company_name' => 'Dropoff PHP Destination',     // required
	    'email' => 'awoss+phpd@dropoff.com',             // required
	    'phone' => '5555554444',                         // required
	    'first_name' => 'Del',                           // required
	    'last_name' => 'Fitzgitibit',                    // required
	    'address_line_1' => '800 Brazos Street',         // required
	    'address_line_2' => '250',                       // optional
	    'city' => 'Austin',                              // required
	    'state' => 'TX',                                 // required
	    'zip' => '78701',                                // required
	    'lat' => 30.269967,                              // required
		'lng' => -97.740838                              // required
	);

	$origin = array(
	    'company_name' => 'Dropoff PHP Destination',     // required
	    'email' => 'awoss+gus@dropoff.com',              // required
	    'phone' => '5124744877',                         // required
	    'first_name' => 'Napoleon',                      // required
	    'last_name' => 'Bonner',                         // required
	    'address_line_1' => '117 San Jacinto Blvd',      // required
	    'city' => 'Austin',                              // required
	    'state' => 'TX',                                 // required
	    'zip' => '78701',                                // required
	    'lat' => 30.263706,                              // required
	    'lng' => -97.741703,                             // required
	    'remarks' => 'Be nice to napoleon'               // optional
	);

---
* **address_line_1** - the street information for the origin or destination.  Required.
* **address_line_2** - additional information for the address for the origin or destination (ie suite number).  Optional.
* **company_name** - the name of the business for the origin or destination.  Required.
* **first_name** -  the first name of the contact at the origin or destination.  Required.
* **last_name** - the last name of the contact at the origin or destination.  Required.
* **phone** -  the contact number at the origin or destination.  Required.
* **email** -  the email address for the origin or destination.  Required.
* **city** -  the city for the origin or destination.  Required.
* **state** -  the state for the origin or destination.  Required.
* **zip** -  the zip code for the origin or destination.  Required.
* **lat** -  the latitude for the origin or destination.  Required.
* **lng** -  the longitude for the origin or destination.  Required.
* **remarks** -  additional instructions for the origin or destination.  Optional.

---

#### Order details data. <a id="order_details_data"></a>

The details contain attributes about the order

	$details = array(
	    'quantity' => 1,                         // required
	    'weight' => 5,                           // required
	    'eta' => '448.5',                        // required
	    'distance' => '0.64',                    // required
	    'price' => '13.99',                      // required
	    'ready_date' => time(),                  // required
	    'type' => 'two_hr',                      // required
	    'reference_name' => 'Reference Name',    // optional
	    'reference_code' => 'Reference Code'     // optional
	);

---
* **quantity** - the number of packages in the order. Required.
* **weight** - the weight of the packages in the order. Required.
* **eta** - the eta from the origin to the destination.  Should use the value retrieved in the getEstimate call. Required.
* **distance** - the distance from the origin to the destination.  Should use the value retrieved in the getEstimate call. Required.
* **price** - the price for the order.  Should use the value retrieved in the getEstimate call.. Required.
* **ready_date** - the unix timestamp (seconds) indicating when the order can be picked up. Can be up to 60 days into the future.  Required.
* **type** - the order window.  Can be asap, two_hr, or four_hr depending on the ready_date. Required.
* **reference_name** - a field for your internal referencing. Optional.
* **reference_code** - a field for your internal referencing. Optional.


#### Order properties data.

The properties section is an array of [property ids](#order_properties) to add to the order

	$properties = array( 2, 3 );

This is an optional piece of data.

#### Order items data.

The items section is an array of line items that meet the conditions specified when getting client's [order item preferences](#order_items).

Some notes about items, here are all possible options that can be included but which are setup for your client must be determined when [getting your order items](#order_items):
- **sku** - Must be a string
- **quantity** - Must be a positive integer
- **weight** - Must be a number greater than 0
- **height** - Must be a number greater than 0
- **depth** - Must be a number greater than 0
- **width** - Must be a number greater than 0
- **unit** - Must be in the array, ['in','ft','cm','mm','m']
- **container** - Must be an integer. Can use the $brawndo->order->containers variable to reference possible containers
- **description** - Must be a string
- **price** - Must be a valid price format in dollars and cents, ex. 10, 10.5, 10.50, 10.0, 10.00
- **temperature** - Must be an integer. Can use the $brawndo->order->temperatures variable to reference possilbe temps
- **person_name** - Must be a string

Passing fields that are disabled for the client will automatically fail creating the order and NOT passing required fields will automatically fail creating the order.

If height, depth, width, or unit is used, then all 4 must be set.  These are all related to **order_item_allow_dimensions**.  That option must be either required or optional to use height, depth, width, or unit.

Qunatity and weight passed in [details](#order_details_data) will be overwritten by the quantity and weight of your items if they are included.  If quantity or weight is optional and only included on some items then those without quantity or weight will increment by 1.  The below example would have a total order weight of 11 and quantity of 4.

```php
$items = array(
  array(
    'sku' => '128UV9',
    'quantity' => 3,
    'weight' => 10,
    'height' => 1.4,
    'width' => 1.2,
    'depth' => 2.3,
    'unit' => 'ft',
    'container' => $brawndo->order->containers['BOX'],
    'description' => 'Box of t-shirts',
    'price' => 59.99,
    'temperature' => $brawndo->order->temperatures['NA'],
    'person_name' => 'T. Shirt'
  ),
  array(
    'sku' => '128UV8',
    'height' => 9.4,
    'width' => 6.2,
    'depth' => 3.3,
    'unit' => 'in',
    'container' => $brawndo->order->containers['BOX'],
    'description' => 'Box of socks',
    'price' => 9.99,
    'temperature' => $brawndo->order->temperatures['NA'],
    'person_name' => 'Jim'
  )
);
```
This can be optional, required, or not allowed depending on the client's order items response.

---
Once this data is created, you can create the order.

	$new_order = array(
	    'origin' => $origin,
	    'destination' => $destination,
	    'details' => $details,
	    'properties' => $properties,
			'items' => $items
	);

	$result = $brawndo->order->create($new_order);
	
Note that if you want to create this order on behalf of a managed client as an enterprise client user you will need to specify the company_id.

	$new_order = array(
	    'origin' => $origin,
	    'destination' => $destination,
	    'details' => $details,
	    'properties' => $properties,
			'items' => $items
	    'company_id' => $company_id
	);

	$result = $brawndo->order->create($new_order);

The data in the return value will contain the id of the new order as well as the url where you can track the order progress.


### Cancelling an order <a id="cancel"></a>

    //Cancel an order created for the client that your keys represent
    $order_id = '12345fedcba67890abcdef';
    $result = $brawndo->order->cancel($order_id);

    //Cancel an order created for a managed client that is a descendant of your enterprise client that your keys represent
    $order_id = '123321abcdeffedcba6789';
    $company_id = '1111111111111';
    $result = $brawndo->order->cancel($order_id, $company_id);
    
---
* **order_id** - the id of the order to cancel.
* **company_id** - if you are using brawndo as an enterprise client that manages other dropoff clients you can specify the managed client id who you would like to cancel an order for. This is optional and only works for enterprise clients.
---

An order can be cancelled in these situations

* The order was placed less than **ten minutes** ago.
* The order ready time is more than **one hour** away.
* The order has not been picked up.
* The order has not been cancelled.

    
### Getting a specific order <a id="specific"></a>

    //Read an order created for the client that your keys represent
    $order_id = '12345fedcba67890abcdef';
    $result = $brawndo->order->read($order_id);

    //Read an order created for a managed client that is a descendant of your enterprise client that your keys represent
    $order_id = '123321abcdeffedcba6789';
    $company_id = '1111111111111';
    $result = $brawndo->order->read($order_id, $company_id);

---
* **order_id** - the id of the order to read.
* **company_id** - if you are using brawndo as an enterprise client that manages other dropoff clients you can specify the managed client id who's order you would like to read. This is optional and only works for enterprise clients.
---

Example response

	array(3) {
	  ["data"]=>
	  array(3) {
	    ["destination"]=>
	    array(16) {
	      ["zip"]=>
	      string(5) "78701"
	      ["lng"]=>
	      float(-97.740838)
	      ["city"]=>
	      string(6) "Austin"
	      ["last_name"]=>
	      string(7) "Bobobob"
	      ["createdate"]=>
	      int(1455807688)
	      ["email_address"]=>
	      string(22) "deliveries@dropoff.com"
	      ["updatedate"]=>
	      int(1455807688)
	      ["company_name"]=>
	      string(12) "Dropoff Inc."
	      ["address_line_1"]=>
	      string(17) "800 Brazos Street"
	      ["order_status_code"]=>
	      int(0)
	      ["phone_number"]=>
	      string(10) "8444376763"
	      ["address_line_2"]=>
	      string(3) "250"
	      ["state"]=>
	      string(2) "TX"
	      ["first_name"]=>
	      string(5) "Algis"
	      ["order_id"]=>
	      string(13) "61AE-Ozd7-L12"
	      ["lat"]=>
	      float(30.269967)
	    }
	    ["details"]=>
	    array(23) {
	      ["distance"]=>
	      string(4) "0.64"
	      ["timezone"]=>
	      string(15) "America/Chicago"
	      ["time_frame"]=>
	      string(6) "two_hr"
	      ["simulation"]=>
	      bool(false)
	      ["createdate"]=>
	      int(1455807688)
	      ["type"]=>
	      string(3) "2HR"
	      ["utc_offset_minutes"]=>
	      int(-360)
	      ["updatedate"]=>
	      int(1455807688)
	      ["price"]=>
	      string(5) "13.99"
	      ["order_status_code"]=>
	      int(0)
	      ["quantity"]=>
	      int(1)
	      ["wait_time"]=>
	      int(0)
	      ["pickupETA"]=>
	      string(3) "TBD"
	      ["weight"]=>
	      int(5)
	      ["signed"]=>
	      string(5) "false"
	      ["readyforpickupdate"]=>
	      int(1455893912)
	      ["market"]=>
	      string(6) "austin"
	      ["service_type"]=>
	      string(8) "standard"
	      ["order_status_name"]=>
	      string(9) "Submitted"
	      ["signature_exists"]=>
	      string(2) "NO"
	      ["customer_name"]=>
	      string(10) "Algis Woss"
	      ["order_id"]=>
	      string(13) "61AE-Ozd7-L12"
	      ["deliveryETA"]=>
	      string(5) "448.5"
	    }
	    ["origin"]=>
	    array(17) {
	      ["zip"]=>
	      string(5) "78701"
	      ["lng"]=>
	      float(-97.741703)
	      ["city"]=>
	      string(6) "Austin"
	      ["last_name"]=>
	      string(6) "Bonner"
	      ["createdate"]=>
	      int(1455807688)
	      ["market"]=>
	      string(6) "austin"
	      ["email_address"]=>
	      string(27) "orders@gussfriedchicken.com"
	      ["updatedate"]=>
	      int(1455807688)
	      ["company_name"]=>
	      string(19) "Gus's Fried Chicken"
	      ["address_line_1"]=>
	      string(20) "117 San Jacinto Blvd"
	      ["order_status_code"]=>
	      int(0)
	      ["phone_number"]=>
	      string(10) "5124744877"
	      ["state"]=>
	      string(2) "TX"
	      ["first_name"]=>
	      string(8) "Napoleon"
	      ["order_id"]=>
	      string(13) "61AE-Ozd7-L12"
	      ["remarks"]=>
	      string(19) "Be nice to napoleon"
	      ["lat"]=>
	      float(30.263706)
	    }
	    ["properties"]=>
		  array(2) {
		    [0]=>
		    array(6) {
		      ["id"]=>
		      int(2)
		      ["label"]=>
		      string(18) "Signature Required"
		      ["description"]=>
		      string(37) "Signature is required for this order."
		      ["price_adjustment"]=>
		      int(0)
		      ["conflicts"]=>
		      array(1) {
		        [0]=>
		        int(1)
		      }
		      ["requires"]=>
		      array(0) {
		      }
		    }
		    [1]=>
		    array(6) {
		      ["id"]=>
		      int(3)
		      ["label"]=>
		      string(12) "Legal Filing"
		      ["description"]=>
		      string(85) "This order is a legal filing at the court house. Please read order remarks carefully."
		      ["price_adjustment"]=>
		      int(5.50)
		      ["conflicts"]=>
		      array(0) {
		      }
		      ["requires"]=>
		      array(1) {
		        [0]=>
		        int(2)
		      }
		      }
		    }
		  }
	  }
	  ["success"]=>
	  bool(true)
	  ["timestamp"]=>
	  string(25) "2016-02-26T14:21:09+00:00"
	}


### Getting a page order <a id="page"></a>

    // Get the first page of orders for your client
    $result = $brawndo->order->readPage();
    
    // Get the page of orders for your client following the given last key.
    $last_key = 'adfsjlhksadfjklfdasjklfadsjklfadsjklafsdjhk'
    $result = $brawndo->order->readPage($last_key);
    
    // Get the first page of orders for a managed client
    $company_id = '1111111111111';
    $result = $brawndo->order->readPage(NULL, $company_id);
    
    // Get the page of orders for a managed client following the given last key.
    $last_key = 'adfsjlhksadfjklfdasjklfadsjklfadsjklafsdjhk'
    $company_id = '1111111111111';
    $result = $brawndo->order->readPage($last_key, $company_id);


---
* **last_key** - the id of the order to read.
* **company_id** - if you are using brawndo as an enterprise client that manages other dropoff clients you can specify the managed client id who's order pages you would like to read. This is optional and only works for enterprise clients.
---

Example response

	array(7) {
	  ["count"]=>
	  int(10)
	  ["data"]=>
	  array(10) { ..... }
	  ["total"]=>
	  int(804)
	  ["success"]=>
	  bool(true)
	  ["timestamp"]=>
	  string(25) "2016-02-26T14:26:32+00:00"
	  ["last_key"]=>
	  string(172) "/YrqnazKwAui730mLfYT3eSEctmIAyzlEt80lkZJAJB4QyAhjH0ukYdJBI0w2Dcgl4/7k4pO6JTxP/U4hGXkH9kCVaqijcQU97FvxfABqjBSsJEt+Kh3igFeFgBZ3CV+JUn6ODMbhc9KXMnwEXx0fQ54D3lpY3jJHLh5xvFQmOM="
	}

Use **last_key** to get the subsequent page of orders.

## Signature Image URL<a id="signature"></a>

Some orders will contain signatures.  If you want to get a url to an image of the signature you can call the **signature** function.  Note that the signature may not always exist, for example when the delivery was left at the door of the destination.

	$result = $brawndo->order->signature("zzzz-zzzz-zzz");

Example response

	array(2) {
		["success"]=>
  		bool(true)
  		["url"]=>
  		string(234) "https://s3.amazonaws.com/..."
	}

**The signature url is configured with an expiration time of 5 minutes after the request for the resource was made**		

## Tips <a id="tips"></a>

You can create, delete, and read tips for individual orders.  Please note that tips can only be created or deleted for orders that were delivered within the current billing period.  Tips are paid out to our agents and will appear as an order adjustment charge on your invoice after the current billing period has expired.  Tip amounts must not be zero or negative.  You are limited to one tip per order.

### Creating a tip <a id="tip_create"></a>

Tip creation requires two parameters, the order id **(order_id)** and the tip amount **(amount)**.

    $order_id = 'abcdef0987654321fedcba';
    $amount = 13.33;
    $result = $brawndo->order->tip->create($order_id, $amount);

    $order_id = '1234567890abcdef54321';
    $amount = 22.22;
    $company_id = '1111111111111';
    $result = $brawndo->order->tip->create($order_id, $amount, $company_id);

---
* **order_id** - the order id you want to add the tip to.
* **amount** - the amount of the tip.
* **company_id** -  if you are using brawndo as an enterprise client that manages other dropoff clients you can specify the managed client id who who has an order you want to add a tip to. This is optional and only works for enterprise clients.
---
    
### Deleting a tip <a id="tip_delete"></a>

Tip deletion only requires the order id **(order_id)**.

    $order_id = 'abcdef0987654321fedcba';
    $result = $brawndo->order->tip->delete($order_id);

    $order_id = '1234567890abcdef54321';
    $company_id = '1111111111111';
    $result = $brawndo->order->tip->delete($order_id, $company_id);

---
* **order_id** - the order id you want to delete the tip from.
* **company_id** -  if you are using brawndo as an enterprise client that manages other dropoff clients you can specify the managed client id who who has an order you want to remove a tip from. This is optional and only works for enterprise clients.
---

### Reading a tip <a id="tip_read"></a>

Tip reading only requires the order id **(order_id)**.

    $order_id = 'abcdef0987654321fedcba';
    $result = $brawndo->order->tip->read($order_id);

    $order_id = '1234567890abcdef54321';
    $company_id = '1111111111111';
    $result = $brawndo->order->tip->read($order_id, $company_id);

Example response:

	array(4) {
	  ["amount"]=>
	  string(5) "13.33"
	  ["description"]=>
	  string(32) "Tip added by Dropoff(Algis Woss)"
	  ["createdate"]=>
	  string(25) "2016-02-26T14:33:15+00:00"
	  ["updatedate"]=>
	  string(25) "2016-02-26T14:33:15+00:00"
	}

---
* **order_id** - the order id who's tip you want to see.
* **company_id** -  if you are using brawndo as an enterprise client that manages other dropoff clients you can specify the managed client id who who has an order who's tip you want to see. This is optional and only works for enterprise clients.
---

## Webhooks <a id="webhook"></a>

You may register a server route with Dropoff to receive real time updates related to your orders.

Your endpoint must handle a post, and should verify the X-Dropoff-Key with the client key given to you when registering the endpoint.

The body of the post should be signed using the HMAC-SHA-512 hashing algorithm combined with the client secret give to you when registering the endpoint.

The format of a post from Dropoff will be:

    {
        count : 2,
        data : [ ]
    }

* **count** contains the number of items in the data array.
* **data** is an array of events regarding orders and agents processing those orders.

### Backoff algorithm <a id="backoff"></a>

If your endpoint is unavailable Dropoff will try to resend the events in this manner:

*  Retry 1 after 10 seconds
*  Retry 2 after twenty seconds
*  Retry 3 after thirty seconds
*  Retry 4 after one minute
*  Retry 5 after five minutes
*  Retry 6 after ten minutes
*  Retry 7 after fifteen minutes
*  Retry 8 after twenty minutes
*  Retry 9 after thirty minutes
*  Retry 10 after forty five minutes
*  All subsequent retries will be after one hour until 24 hours have passed

**If all retries have failed then the cached events will be forever gone from this plane of existence.**

### Events <a id="events"></a>

There are two types of events that your webhook will receive, order update events and agent location events.

All events follow this structure:

    {
        event_name : <the name of the event ORDER_UPDATED or AGENT_LOCATION>
        data : { ... }
    }

* **event_name** is either **ORDER_UPDATED** or **AGENT_LOCATION**
* **data** contains the event specific information

#### Order Update Event

This event will be triggered when the order is either:

* Accepted by an agent.
* Picked up by an agent.
* Delivered by an agent.
* Cancelled.

This is an example of an order update event

    {
        event_name: 'ORDER_UPDATED',
        data: {
            order_status_code: 1000,
            company_id: '7df2b0bdb418157609c0d5766fb7fb12',
            timestamp: '2015-05-15T12:52:55+00:00',
            order_id: 'klAb-zwm8-mYz',
            agent_id: 'b7aa983243ccbfa43410888dd205c298'
        }
    }

* **order_status_code** can be -1000 (cancelled), 1000 (accepted), 2000 (picked up), or 3000 (delivered)
* **company_id** is your company id.
* **timestamp** is a utc timestamp of when the order occured.
* **order_id** is the id of the order.
* **agent_id** is the id of the agent that is carrying out your order.

#### Agent Location Update Event

This event is triggered when the location of an agent that is carrying out your order has changed.

    {
        event_name: 'AGENT_LOCATION',
        data: {
            agent_avatar: 'https://s3.amazonaws.com/com.dropoff.alpha.app.workerphoto/b7aa983243ccbfa43410888dd205c298/worker_photo.png?AWSAccessKeyId=AKIAJN2ULWKTZXXEOQDA&Expires=1431695270&Signature=AFKNQdT33lhlEddrGp0kINAR4uw%3D',
            latitude: 30.2640713,
            longitude: -97.7469492,
            order_id: 'klAb-zwm8-mYz',
            timestamp: '2015-05-15T12:52:50+00:00',
            agent_id: 'b7aa983243ccbfa43410888dd205c298'
        }
    }

* **agent_avatar** is an image url you can use to show the agent.  It expires in 15 minutes.
* **latitude** and **longitude** reflect the new coordinates of the agent.
* **timestamp** is a utc timestamp of when the order occured.
* **order_id** is the id of the order.
* **agent_id** is the id of the agent that is carrying out your order.

#### Managed Client Events<a id="managed_client_events"></a>

If you have registered a webhook with an enterprise client that can manager other clients, then the webhook will also receive all events for any managed clients.

So in our hierarchical [example](#managed_clients) at the start, if a webhook was registered for **EnterpriseCo Global**, it would receive all events for:

- EnterpriseCo Global
- EnterpriseCo Europe
- EnterpriseCo Paris
- EnterpriseCo London
- EnterpriseCo Milan
- EnterpriseCo NA
- EnterpriseCo Chicago
- EnterpriseCo New York
- EnterpriseCo Los Angeles


### Simulating an order<a id="simulation"></a>

You can simulate an order via the brawndo api in order to test your webhooks.

The simulation will create an order, assign it to a simulation agent, and move the agent from pickup to the destination.

**You can only run a simulation once every fifteen minutes.**

    $result = $brawndo->$order->$simulate('austin');