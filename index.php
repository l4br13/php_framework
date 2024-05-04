<?php namespace activity;

define("__INDEX__", __FILE__) OR exit;

define("__SYSTEM__", include_once "include/system.php");

use activity;

final class index extends activity {
	protected static function main(array $argv = [], array $envp = []) {
		system("clear");
		echo "hello world!";
		echo PHP_EOL;
	}
}