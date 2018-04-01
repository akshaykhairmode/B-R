<?php

class Install extends Connection {

    private $structure_path,$structure_data;

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

    public function __construct() {

      parent::__construct();

      $this->structure_path = ABSPATH . "/storage/structure.txt";

    }

    public function install () {

      $this->getStructure()->readStructure();

    }

}