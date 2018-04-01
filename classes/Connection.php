<?php

abstract class Connection {

  protected $db;

  protected function createConn () {

      $conn = new \mysqli(hostname,username,password,database);

      if (mysqli_connect_error()) {
          die("Database connection failed: " . mysqli_connect_error());
      }

      return $conn;
  }

  protected function createZip () {
    
    $zip = new ZipArchive();

    if ($zip->open("../storage/structure_data.zip", ZIPARCHIVE::CREATE) != TRUE) {
          die ("Could not open zip");
      }

    return $zip;
  }

   static function convertSlash ($string) {
    return str_replace("\\", "/", $string);
  }

  public function __construct() {
      $this->db = $this->createConn();
  }

}