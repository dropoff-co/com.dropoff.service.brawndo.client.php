<?php
/**
 * Created by PhpStorm.
 * User: alwoss
 * Date: 2/25/16
 * Time: 1:32 PM
 */

namespace Dropoff;

require_once 'HTTP/Request2.php';
include 'Tip.php';

use Tip;

class Order
{
    protected $utils;
    public $tip;
    public $temperatures = array(
        'NA' =>  0,
        'AMBIENT' => 100,
        'REFRIGERATED' => 200,
        'FROZEN' => 300
    );

    public $containers = array(
        'NA' => 0,
        'BAG' => 100,
        'BOX' => 200,
        'TRAY' => 300,
        'PALLET' => 400,
        'BARREL' => 500,
        'BASKET' => 600,
        'BUCKET' => 700,
        'CARTON' => 800,
        'CASE' => 900,
        'COOLER' => 1000,
        'CRATE' => 1100,
        'TOTE' => 1200
    );

    function __construct($utils)
    {
        $this->utils = $utils;
        $this->tip = new \Dropoff\Tip($utils);
    }

    public function properties($company_id = NULL)
    {
        $request = NULL;
        if (!is_null($company_id)) {
            $query = array(
                'company_id' => company_id
            );
            $request = $this->utils->createSignedRequest('/order/properties', 'order', \HTTP_Request2::METHOD_GET, $query);
        } else {
            $request = $this->utils->createSignedRequest('/order/properties', 'order', \HTTP_Request2::METHOD_GET);
        }
        $request->setHeader('Content-type: application/json; charset=utf-8');
        return $this->utils->sendRequest($request);
    }

    public function signature($order_id, $company_id = NULL)
    {
        $request = NULL;
        if (!is_null($company_id)) {
            $query = array(
                'company_id' => $company_id
            );
            $request = $this->utils->createSignedRequest('/order/signature/' . $order_id, 'order', \HTTP_Request2::METHOD_GET, $query);
        } else {
            $request = $this->utils->createSignedRequest('/order/signature/' . $order_id, 'order', \HTTP_Request2::METHOD_GET);
        }
        return $this->utils->sendRequest($request);
    }

    public function create($order_data, $company_id = NULL)
    {
        $request = NULL;
        if (!is_null($company_id)) {
            $query = array(
                'company_id' => company_id
            );
            $request = $this->utils->createSignedRequest('/order', 'order', \HTTP_Request2::METHOD_POST, $query);
        } else {
            $request = $this->utils->createSignedRequest('/order', 'order', \HTTP_Request2::METHOD_POST);
        }
        $request->setHeader('Content-type: application/json; charset=utf-8');
        $request->setBody(json_encode($order_data));
        return $this->utils->sendRequest($request);
    }

    public function read($order_id, $company_id = NULL)
    {
        $request = NULL;
        if (!is_null($company_id)) {
            $query = array(
                'company_id' => $company_id
            );
            $request = $this->utils->createSignedRequest('/order/' . $order_id, 'order', \HTTP_Request2::METHOD_GET, $query);
        } else {
            $request = $this->utils->createSignedRequest('/order/' . $order_id, 'order', \HTTP_Request2::METHOD_GET);
        }
        return $this->utils->sendRequest($request);
    }

    public function cancel($order_id, $company_id = NULL)
    {
        $request = NULL;
        if (!is_null($company_id)) {
            $query = array(
                'company_id' => $company_id
            );
            $request = $this->utils->createSignedRequest('/order/' . $order_id . '/cancel', 'order', \HTTP_Request2::METHOD_POST, $query);
        } else {
            $request = $this->utils->createSignedRequest('/order/' . $order_id . '/cancel', 'order', \HTTP_Request2::METHOD_POST);
        }
        return $this->utils->sendRequest($request);
    }

    public function readPage($last_key = NULL, $company_id = NULL)
    {
        $query = NULL;
        if (!is_null($last_key)) {
            $query = array(
                'last_key' => $last_key
            );
            if (!is_null($company_id)) {
                $query['company_id'] = $company_id;
            }
        } else if (!is_null($company_id)) {
            $query = array(
                'company_id' => $company_id
            );
        }
        $request = $this->utils->createSignedRequest('/order', 'order', \HTTP_Request2::METHOD_GET, $query);
        return $this->utils->sendRequest($request);
    }

    public function simulate($market = NULL, $order_id = NULL, $company_id = NULL)
    {
        $request = NULL;
        if (!is_null($company_id)) {
            $query = array(
                'company_id' => $company_id
            );
            if (!is_null($market)) {
                $request = $this->utils->createSignedRequest('/order/simulate/' . $market, 'order', \HTTP_Request2::METHOD_GET, $query);
            } else if (!is_null($order_id)) {
                $request = $this->utils->createSignedRequest('/order/simulate/order/' . $order_id, 'order', \HTTP_Request2::METHOD_GET, $query);
            }

        } else {
            if (!is_null($market)) {
                $request = $this->utils->createSignedRequest('/order/simulate/' . $market, 'order', \HTTP_Request2::METHOD_GET);
            } else if (!is_null($order_id)) {
                $request = $this->utils->createSignedRequest('/order/simulate/order/' . $order_id, 'order', \HTTP_Request2::METHOD_GET);
            }
        }

        return $this->utils->sendRequest($request);
    }

    public function items($company_id = NULL)
    {
        $request = NULL;
        if (!is_null($company_id)) {
            $query = array(
                'company_id' => company_id
            );
            $request = $this->utils->createSignedRequest('/order/items', 'order', \HTTP_Request2::METHOD_GET, $query);
        } else {
            $request = $this->utils->createSignedRequest('/order/items', 'order', \HTTP_Request2::METHOD_GET);
        }
        $request->setHeader('Content-type: application/json; charset=utf-8');
        return $this->utils->sendRequest($request);
    }
}