<?php namespace index;

include_once "include/autoload.php";

use activity;

final class main extends activity {
	protected static function activity() {
		var_dump(self::$instance);
	}
}