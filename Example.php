<?php
/**
 * Created by PhpStorm.
 * User: alwoss
 * Date: 2/25/16
 * Time: 1:52 PM
 */

include 'Brawndo.php';

$public_key = "a7a3e9b9aa2c2cd045dbf9b62ff45b77e095b55373f2ad25afaf880675a4ecb3";
$secret_key = "6b85176cc14c19f05f14d9c8470006699a87bba8d87982e2ce66cda195151a7a";

$brawndo = new \Dropoff\Brawndo($public_key, $secret_key, 'http://localhost:9094/v1', 'localhost:9094');
$result = $brawndo->info();
var_dump($result);

$result = $brawndo->order->properties();
var_dump($result);

//$result = $brawndo->estimate('800 Brazos St, Austin, TX 78701', '2517 Thornton Rd, Austin, TX 78704', date('P'), time());
//$result = $brawndo->order->read('c969c2a46eb5bc7d007ddc0e10187116');
//$result = $brawndo->order->readPage();
//$result = $brawndo->order->readPage('/YrqnazKwAui730mLfYT3eSEctmIAyzlEt80lkZJAJB4QyAhjH0ukYdJBI0w2Dcgl4/7k4pO6JTxP/U4hGXkH9kCVaqijcQU97FvxfABqjBSsJEt+Kh3igFeFgBZ3CV+JUn6ODMbhc9KXMnwEXx0fQ54D3lpY3jJHLh5xvFQmOM=');
//$result = $brawndo->order->tip->read('c969c2a46eb5bc7d007ddc0e10187116');
//$result = $brawndo->order->tip->create('c969c2a46eb5bc7d007ddc0e10187116', 13.33);
//$result = $brawndo->order->tip->delete('c969c2a46eb5bc7d007ddc0e10187116');
//
//$new_destination = array(
//    'company_name' => 'Dropoff PHP Destination',
//    'email' => 'awoss+phpd@dropoff.com',
//    'phone_number' => '5555554444',
//    'first_name' => 'Del',
//    'last_name' => 'Fitzgitibit',
//    'address_line_1' => '800 Brazos Street',
//    'address_line_2' => '250',
//    'city' => 'Austin',
//    'state' => 'TX',
//    'zip' => '78701',
//    'lat' => 30.269967,
//    'lng' => -97.740838
//);
//
//$new_origin = array(
//    'company_name' => 'Dropoff PHP Destination',
//    'email' => 'awoss+gus@dropoff.com',
//    'phone_number' => '5124744877',
//    'first_name' => 'Napoleon',
//    'last_name' => 'Bonner',
//    'address_line_1' => '117 San Jacinto Blvd',
//    'city' => 'Austin',
//    'state' => 'TX',
//    'zip' => '78701',
//    'lat' => 30.263706,
//    'lng' => -97.741703,
//    'remarks' => 'Be nice to napoleon'
//);
//$new_details = array(
//    'quantity' => 1,
//    'weight' => 5,
//    'eta' => '448.5',
//    'distance' => '0.64',
//    'price' => '13.99',
//    'ready_date' => time(),
//    'type' => 'two_hr'
//);
//$new_order = array(
//    'origin' => $new_origin,
//    'destination' => $new_destination,
//    'details' => $new_details
//);
//
//$result = $brawndo->order->create($new_order);  //2aafc8569ede55dafdefc113626ee840

//$result = $brawndo->order->cancel('2aafc8569ede55dafdefc113626ee840');

//var_dump($result);
