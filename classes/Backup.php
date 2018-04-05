<?php
/*
Author :- Akshay Khairmode
*/
class Backup extends Connection {

  private $zip,$structure,$unlink;

  public function __construct() {

      parent::__construct();

      $this->zip = $this->createZip();
      $this->structure = array();
      $this->unlink = array();
  }

  public function getAllTables () {

      $return = array();

      $query = "SELECT 
                    TABLE_NAME, 
                    TABLE_ROWS 
                FROM 
                    `information_schema`.`tables` 
                WHERE 
                    `table_schema` = '".database."'";

      $result = $this->db->query($query);


      if($result->num_rows > 0) {
        $return = $result->fetch_all(MYSQL_ASSOC);
      } else {
        die("No Tables Found");
      }

      return $return;
  }

  /*Creating an array for structure to serialize and store the data*/ 

  private function addToArray ($filename,$content) {

    $key_value = array("filename"=>$filename,"content"=>$content);

    array_push($this->structure, $key_value);    

  }

  /*Close the file handle for structure*/

  private function complete_structure () {

      $path = "../storage/structure.txt";

      $myfile = fopen($path, "w") or die("Unable to open file!");
      fwrite($myfile, serialize($this->structure));
      fclose($myfile);

  }

  private function parseStructure ($tables) {

      $tables = array_unique($tables);

      foreach ($tables as $table_name) {
        
        $query_fire = $this->db->query("SHOW CREATE TABLE ".$table_name) or mdie();

        $res = $query_fire->fetch_assoc();

        $this->addToArray($res['Table'],$res['Create Table']);

      }

      $this->complete_structure();

      return $this;

  }

  /*Unlink all the files after creating a zip for structure and data*/
  private function unlink_data () {

    foreach ($this->unlink as $path) {
      unlink($path);
    }

  }

  /*Export all the data*/
  private function exportData ($tables) {

      foreach ($tables as $key => $table_name) {
           $filename = $table_name.".csv";

            $path = static::convertSlash(realpath("../storage").DS.$filename);

            $query = "SELECT * INTO OUTFILE \"$path\"\n"
            . "FIELDS TERMINATED BY \",\" OPTIONALLY ENCLOSED BY '\"' \n"
            . "LINES TERMINATED BY \"\\n\"\n"
            . "FROM ".$table_name;

            $query_fire = $this->db->query($query) or mdie();

            $this->zip->addFile($path,$filename) or die("Error while adding file");

            array_push($this->unlink, $path);

      }

      $this->zip->close();

      $this->unlink_data();

      return $this;
  }

  public function backup ($d1,$d2) {

    $this->parseStructure(array_merge($d1,$d2))->exportData($d2);

    echo "Backup Complete";

  }

}
?>