<?php

namespace Func;

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