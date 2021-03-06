<?php
/**
 * Created by PhpStorm.
 * User: alwoss
 * Date: 2/25/16
 * Time: 1:32 PM
 */

namespace Dropoff;

require_once 'HTTP/Request2.php';
require_once 'Utils.php';
require_once 'Order.php';

use Utils;
use Order;

class Brawndo
{
    public $order;
    protected $utils;

    function __construct($public_key,$secret_key,$url,$host) {
        $this->utils = new \Dropoff\Utils($public_key,$secret_key,$url,$host);
        $this->order = new \Dropoff\Order($this->utils);
    }

    public function estimate($origin, $destination, $utc_offset, $ready_timestamp = NULL, $company_id = NULL) {
        $query = array(
            'origin'        => $origin,
            'destination'   => $destination,
            'utc_offset'    => $utc_offset);

        if (!is_null($ready_timestamp)) {
            $query['ready_timestamp'] = $ready_timestamp;
        }

        if (!is_null($company_id)) {
            $query['company_id'] = $company_id;
        }

        $request = $this->utils->createSignedRequest('/estimate', 'estimate', \HTTP_Request2::METHOD_GET, $query);
        return $this->utils->sendRequest($request);
    }

    public function info() {
        $request = $this->utils->createSignedRequest('/info', 'info', \HTTP_Request2::METHOD_GET);
        return $this->utils->sendRequest($request);
    }
}
