<?php

class Install extends Connection {

    private $structure_path,$structure_data,$data_path,$extract;

    private function getStructure() {

        if(file_exists($this->structure_path)) {

          $this->structure_data = file_get_contents($this->structure_path) or die("There was some problem while reading structure");

        }else{

          die("Structure.txt is missing");

        }

        return $this;
    }

    private function createTable($arr){

      $new_name = $arr['filename'] . "_BR_" . NAME . "_" . strtotime("NOW");

      $rename_query = "RENAME TABLE ".$arr['filename'] . " TO ".$new_name;

      $this->db->query($rename_query) or mdie();
      
      $this->db->query($arr['content']) or mdie();

      return $this;
    }

    private function readStructure() {

        $structure = unserialize($this->structure_data);
        foreach ($structure as $value) {
          
            $table_name = $value['filename'];
            $create_table = $value['content'];

            $this->createTable($value);

        }

    }

    private function importCsv ($path) {

      $table_name = str_replace(".csv", "", basename($path)); 

      $query = "LOAD DATA INFILE '".$path."' INTO TABLE ".$table_name 
              ." FIELDS TERMINATED BY ',' "
              ." LINES TERMINATED BY '\\n'";

      $this->db->query($query) or mdie();

    }

    private function readFiles () {

        $files = glob($this->extract.'*');

        foreach ($files as $key => $file_path) {
            $this->importCsv($file_path);
        }

        return $this;

    }

    //Read and extract zip
    private function readZip() {

      $zip = new ZipArchive();

      if ($zip->open($this->data_path) == TRUE) {

        $zip->extractTo($this->extract);
        $zip->close();

      }

      return $this;

    }

    public function __construct() {

      parent::__construct();

      $this->structure_path = ABSPATH . "/storage/structure.txt";
      $this->data_path = ABSPATH . "/storage/structure_data.zip";
      $this->extract = ABSPATH . "/storage/extract/";

    }

    public function install () {

      $this->getStructure()->readStructure();

      $this->readZip()->readFiles();

    }

}