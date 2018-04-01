<?php

require "../config.php";

$form_data = $_POST['form_data'];

$structure_arr = $structure_data_arr = array();

parse_str($form_data , $data);

if(!empty($data['structure'])) {
	$structure_arr = $data['structure'];
}

if(!empty($data['structure_data'])) {
	$structure_data_arr = $data['structure_data'];
}

if(empty($structure_arr) && empty($structure_data_arr)) {
	die("Please select at least one table");
}

$db = new Backup;

$db->backup($structure_arr,$structure_data_arr);
