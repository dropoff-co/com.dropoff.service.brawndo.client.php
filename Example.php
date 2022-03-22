<?php
/**
 * Created by PhpStorm.
 * User: alwoss
 * Date: 2/25/16
 * Time: 1:52 PM
 */

include 'Brawndo.php';

$public_key = "";
$secret_key = "";

$brawndo = new \Dropoff\Brawndo($public_key, $secret_key, 'https://sandbox-brawndo.dropoff.com/v1', 'sandbox-brawndo.dropoff.com');
$result = $brawndo->info();
var_dump($result);
// $filename = "./shortest copy.csv";
// $result = $brawndo->bulk->create($filename);
// var_dump($result);
$bulk_id = "919d839c5d6b6f422f7377562af9dff6";
$result = $brawndo->bulk->cancel($bulk_id);
var_dump($result);

// // $result = $brawndo->order->properties();
// // var_dump($result);

// // $company_id = ""; //optional
// // $result = $brawndo->order->driverActionsMeta($company_id);
// // var_dump($result);

// // $result = $brawndo->order->items();
// // var_dump($result);

// //$result = $brawndo->estimate('117 San Jacinto Blvd, Austin, TX 78701', '1601 S MoPac Expy, Austin, TX 78746', date('P'), time());
// // $result = $brawndo->order->read('mvB0-1jeQ-N20');
// //$result = $brawndo->order->readPage();
// //$result = $brawndo->order->readPage('/YrqnazKwAui730mLfYT3eSEctmIAyzlEt80lkZJAJB4QyAhjH0ukYdJBI0w2Dcgl4/7k4pO6JTxP/U4hGXkH9kCVaqijcQU97FvxfABqjBSsJEt+Kh3igFeFgBZ3CV+JUn6ODMbhc9KXMnwEXx0fQ54D3lpY3jJHLh5xvFQmOM=');
// //$result = $brawndo->order->tip->read('c969c2a46eb5bc7d007ddc0e10187116');
// //$result = $brawndo->order->tip->create('c969c2a46eb5bc7d007ddc0e10187116', 13.33);
// //$result = $brawndo->order->tip->delete('c969c2a46eb5bc7d007ddc0e10187116');
// //

// var_dump($result);

// $new_destination = array(
//    'company_name' => 'Dropoff PHP Destination',
//    'email' => 'awoss+phpd@dropoff.com',
//    'first_name' => 'Del',
//    'last_name' => 'Fitzgitibit',
//    'address_line_1' => '1601 S MoPac Expy',
//    'address_line_2' => 'C301',
//    'phone' => '5125555555',
//    'city' => 'Austin',
//    'state' => 'TX',
//    'zip' => '78746',
//    'lat' => 30.260228,
//    'lng' => -97.740838,
//    'driver_actions' => '2400,2500'
// );

// $new_origin = array(
//    'company_name' => 'Dropoff PHP Destination',
//    'email' => 'awoss+gus@dropoff.com',
//    'first_name' => 'Napoleon',
//    'last_name' => 'Bonner',
//    'address_line_1' => '117 San Jacinto Blvd',
//    'phone' => '5125555555',
//    'city' => 'Austin',
//    'state' => 'TX',
//    'zip' => '78701',
//    'lat' => 30.263706,
//    'lng' => -97.741703,
//    'remarks' => 'Be nice to napoleon',
//    'driver_actions' => '1400'
// );

// $in_two_hours = time() + 7200;

// $new_details = array(
//    'quantity' => 1,
//    'weight' => 5,
//    'eta' => '448.5',
//    'distance' => '0.64',
//    'price' => '13.99',
//    'ready_date' => $in_two_hours,
//    'type' => 'two_hr'
// );

// $items = array(
//   array(
//     'sku' => '128UV9',
//     'quantity' => 3,
//     'weight' => 10,
//     'height' => 1.4,
//     'width' => 1.2,
//     'depth' => 2.3,
//     'unit' => 'ft',
//     'container' => $brawndo->order->containers['BOX'],
//     'description' => 'Box of t-shirts php',
//     'price' => 59.99,
//     'temperature' => $brawndo->order->temperatures['NA'],
//     'person_name' => 'T. Shirt'
//   ),
//   array(
//     'sku' => '128UV8',
//     'height' => 9.4,
//     'width' => 6.2,
//     'depth' => 3.3,
//     'unit' => 'in',
//     'container' => $brawndo->order->containers['BOX'],
//     'description' => 'Box of socks',
//     'price' => 9.99,
//     'temperature' => $brawndo->order->temperatures['NA'],
//     'person_name' => 'Jim'
//   )
// );

// $new_order = array(
//   'origin' => $new_origin,
//   'destination' => $new_destination,
//   'details' => $new_details,
//   // 'items' => $items
// );

// $result = $brawndo->order->create($new_order);
// var_dump($result);
// $order_id = '';

// $result = $brawndo->order->cancel($order_id);
// var_dump($result);

// $result = $brawndo->order->signature($order_id);
// var_dump($result);

// $result = $brawndo->order->pickupSignature($order_id);
// var_dump($result);
