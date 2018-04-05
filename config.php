<?php

//Akshay Khairmode

define("APPNAME","YOUR_APP_NAME");//Change this according to the folder name you have copied to

define("DS" , DIRECTORY_SEPARATOR);

define("ABSPATH",$_SERVER['DOCUMENT_ROOT']."/".APPNAME);

//Path where the app is copied
define("MAIN" , "http://localhost/".APPNAME);//Add IP instead of localhost if on server

define("hostname" , "localhost");

define("username" , "root");

define("password" , "");

define("database" , "");

define("NAME","YOUR_NAME");


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