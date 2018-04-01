<?php

//Akshay Khairmode

define("APPNAME","database");

define("DS" , DIRECTORY_SEPARATOR);

define("ABSPATH",$_SERVER['DOCUMENT_ROOT']."/".APPNAME);

//Path where the app is copied
define("MAIN" , "http://localhost/".APPNAME);

define("hostname" , "localhost");

define("username" , "root");

define("password" , "");

define("database" , "");

define("NAME","Akshay");


function mdie() {
  // die(mysql_error());
  die("MYSQL ERROR OCCURED");
}

function pp($content) {

  if (is_array($content)) {
    echo "<pre>";
    print_r($content);
    echo "</pre>";
  } else {
     echo "<pre>".$content."</pre>";
  }
}

function __autoload($class) {

	require ABSPATH."/classes/".$class.".php";

}