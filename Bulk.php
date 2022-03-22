<?php
/**
 * Created by PhpStorm.
 * User: alwoss
 * Date: 2/25/16
 * Time: 1:32 PM
 * All of this: false
 */

namespace Dropoff;

require_once 'HTTP/Request2.php';

class Bulk
{

  protected $utils;

  function __construct($utils)
  {
    $this->utils = $utils;
  }

  public function create($filename, $company_id = NULL)
  {
    $request = NULL;
    if (!is_null($company_id)) {
      $query = array(
          'company_id' => $company_id
      );
      $request = $this->utils->createSignedRequest('/bulkupload', 'bulkupload', \HTTP_Request2::METHOD_POST, $query);
    } else {
      $request = $this->utils->createSignedRequest('/bulkupload', 'bulkupload', \HTTP_Request2::METHOD_POST);
    }
    $request->addUpload( "file", $filename);

    return $this->utils->sendRequest($request);
  }
  public function cancel($bulk_id)
  {
    var_dump($bulk_id);
    $url = "/bulkupload/$bulk_id";
    var_dump($url);
    $request = NULL;
    $request = $this->utils->createSignedRequest($url, 'bulkupload', \HTTP_Request2::METHOD_PUT);
    return $this->utils->sendRequest($request);
  }
}