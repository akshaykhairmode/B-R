<?php
/*
Author :- Akshay Khairmode
*/
namespace DB_INIT;

require './functions.php';// Used for debugging purpose.
use Func as F;

class Database {

  private $config_path = "config.json";

  private $hostname,$db_user,$db_password,$database,$tables;

  public function __construct() {

      $file_content = file_get_contents($this->config_path);

      $parse_file = json_decode($file_content,true);

      if(!$parse_file) {
        die("Could Not read config file");
      }

      //Initializing
      $config = $parse_file['config'];
      $this->tables = $parse_file['tables'];
      //End

      mysql_connect($config['host'],$config['username'],$config['password']);
      mysql_select_db($config['database']) or F\mdie();

  }

  private function getTableBoth () {//Returns the tables which need both structure and data

    $return = array();

    foreach ($this->tables as $table_name => $status) {
      if ($status == true) {
        array_push($return, $table_name);
      }
    }

    return $return;

  }


  private function createFileStructure ($filename,$content) {//Insert structure of each file.

    $path = "./storage/structure/".$filename.".txt";

    $myfile = fopen($path, "w") or die("Unable to open file!");
    fwrite($myfile, $content);
    fclose($myfile);

  }

  private function createFileFull () {

  }

  private function parseStructure () {

      foreach ($this->tables as $table_name => $status) {
        
        $query_fire = mysql_query("SHOW CREATE TABLE ".$table_name) or F\mdie();

        $res = mysql_fetch_assoc($query_fire);

        $this->createFileStructure($res['Table'],$res['Create Table']);

      }

  }

  private function parseData ($table_name) {

      $filename = $table_name.".csv";

      echo $query = "SELECT * INTO OUTFILE \".".DIRECTORY_SEPARATOR ."storage".DIRECTORY_SEPARATOR ."full".DIRECTORY_SEPARATOR ."test.csv\"\n"
      . "FIELDS TERMINATED BY \',\' OPTIONALLY ENCLOSED BY \'\"\'\n"
      . "LINES TERMINATED BY \"\\n\"\n"
      . "FROM cqms_escalation_master";

      // echo $query = "SELECT * INTO OUTFILE \"./storage/full/test.csv\"\"\n"
      // . "FIELDS TERMINATED BY \',\' OPTIONALLY ENCLOSED BY \'\"\'\n"
      // . "LINES TERMINATED BY \"\\n\"\n"
      // . "FROM ".$table_name;

      // $query_fire = mysql_query($query) or F\mdie();

  }

  public function install () {

  }

  public function backup () {

    $this->parseStructure();//Creates txt files containing the structure code

    mysql_query("START TRANSACTION");

    foreach ($this->getTableBoth() as $table_name) {
        $this->parseData($table_name);
    }

    mysql_query("COMMIT");
    
  }

}


;

$obj = new Database;
$obj->backup();

?>