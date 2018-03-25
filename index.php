<?php
/*
Author :- Akshay Khairmode
*/
namespace DB_INIT;

require './functions.php';
use Func as F;

class Database {

  private $hostname = 'localhost';
  private $db_user = 'root';
  private $db_password = '';
  private $database = 'ciltest_cqms';

  private $tables = array("cqms_category_master"=>true,"cqms_channel_master"=>true,"cqms_escalation_master"=>false);

  public function __construct() {
      mysql_connect($this->hostname,$this->db_user,$this->db_password);
      mysql_select_db($this->database) or F\mdie();
  }

  private function ParseStructure () {

      $query_fire = mysql_query("SHOW CREATE TABLE cqms_category_master") or F\mdie();

      while ($res = mysql_fetch_assoc($query_fire)) {
          F\pp($res);
      }
  }

  private function ParseBoth () {

      $query_fire = mysql_query("SHOW CREATE TABLE cqms_category_master") or F\mdie();

      while ($res = mysql_fetch_assoc($query_fire)) {
          F\pp($res);
      }
  }

  public function ExecuteInstallScript () {

  }

  public function GetTable () {

    foreach ($this->tables as $table_name => $status) {

        if ($status == true) {//If data is required

          

        } elseif($status == false) {

          
          
        }
    }
    
  }

}

$obj = new Database;
$obj->GetTable();

?>