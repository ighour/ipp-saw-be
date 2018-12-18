<?php

class DatabaseConnection {
  //Credentials
  private $creds = [
    'host' => '10.0.80.104',
    'db_name' => 'saw',
    'db_user' => 'saw',
    'db_password' => 'saw'
  ];

  //Connection
  public $connection;

  //Make connection
  public function connect(){
    $this->connection = null;

    $db = 'mysql:host=' . $this->creds['host'] . ';dbname=' . $this->creds['db_name'];

    try {
      $this->connection = new PDO($db, $this->creds['db_user'], $this->creds['db_password']);
    }
    catch(PDOException $exception){
      echo "Connection error: " . $exception->getMessage() . PHP_EOL;
      throw $exception;
    }
    catch(Exception $exception){
      echo "Server error: " . $exception->getMessage() . PHP_EOL;
      throw $exception;
    }

    return $this->connection;
  }
}