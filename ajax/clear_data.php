<?php

function empty_folder ($path) {
	
	$files = glob($path); 
	foreach($files as $file){ 
	  if(is_file($file))
	    unlink($file); 
	}
}

empty_folder("../storage/*");
empty_folder("../storage/extract/*");
