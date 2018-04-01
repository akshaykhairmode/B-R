<?php

//Akshay Khairmode

define("APPNAME","database");

define("DS" , DIRECTORY_SEPARATOR);

define("ABSPATH",$_SERVER['DOCUMENT_ROOT']."/".APPNAME);

define("MAIN" , "http://localhost/database");

define("hostname" , "localhost");

define("username" , "root");

define("password" , "");

define("database" , "ciltest_cqms");

// define("JS", MAIN."/js/");

// define("AJAX", __DIR__.DS."ajax".DS);

// define("CLASSES", __DIR__.DS."classes".DS);

// define("STORAGE" , __DIR__.DS."storage".DS);

// define("VIEW" , ".".DS."views".DS);


function mdie() {
  die(mysql_error());
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