<?php

namespace App\Controller;

abstract class Controller {
  /**
   * Response http code
   */
  private $code;

  /**
   * Response message
   */
  private $message;

  /**
   * Response payload
   */
  private $payload;

  /**
   * Model DAO
   */
  protected $DAO;

  /**
   * Model Resource
   */
  protected $resource;

  /**
   * Request
   */
  protected $request;

  /**
   * Request validation
   */
  protected $validation;

  /**
   * Code Messages
   */
  private $CODES = [
    '200' => "OK",
    '201' => "Created",
    '400' => "Bad Request",
    '404' => "Not Found"
  ];

  /**
   * Constructor
   */
  public function __construct($request = null)
  {
    $this->request = $request;
  }

  /**
   * Filter request parameters
   */
  protected function params($params)
  {
    $result = [];

    foreach($params as $param){
      if(isset($this->request[$param]))
        $result[$param] = $this->request[$param];
    }

    return $result;
  } 

  /**
   * Set response http code
   */
  private function withCode($code)
  {
    $this->code = $code;

    return $this;
  }

  /**
   * Set response message
   */
  private function withMessage($message)
  {
    $this->message = $message;

    return $this;
  }

  /**
   * Set response payload
   */
  protected function withPayload(array $payload)
  {
    $this->payload = $payload;

    return $this;
  }

  /**
   * JSON Respond
   */
  private function respond()
  {
    //Set headers
    header("Access-Control-Allow-Origin: " . getenv('HEADER_ACCESS_CONTROL_ALLOW_ORIGIN'));
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    http_response_code($this->code);

    //Set response
    $response = [
      'code' => $this->code,
      'message' => !is_null($this->message) ? $this->message : $this->CODES[$this->code]
    ];

    //Set payload
    if(!is_null($this->payload))
      $response['payload'] = $this->payload;

    //Respond
    echo json_encode($response);

    die();
  }

  /**
   * Respond OK (200)
   */
  protected function respondOk($message = null)
  {
    $this->withCode(200)->withMessage($message)->respond();
  }

  /**
   * Respond Created (201)
   */
  protected function respondCreated($message = null)
  {
    $this->withCode(201)->withMessage($message)->respond();
  }

  /**
   * Respond Bad Request (400)
   */
  protected function respondBadRequest($message = null)
  {
    $this->withCode(400)->withMessage($message)->respond();
  }

  /**
   * Respond Not Found (404)
   */
  protected function respondNotFound($message = null)
  {
    $this->withCode(404)->withMessage($message)->respond();
  }
}