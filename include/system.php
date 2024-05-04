<?php
final class system {
	protected static $activity;
	protected static $instance;
	public function __construct() {
		defined("__INDEX__") OR exit;
		!defined("__SYSTEM__") OR exit;
		define("SYSTEM_ROOT", dirname(__INDEX__));
		define("DIR_SEPARATOR", DIRECTORY_SEPARATOR);
		define("SYSTEM_API", PHP_SAPI);
		define("SYSTEM_AUTOLOAD", spl_autoload_register(function (string $class) {
			$basename = str_replace("\\", ".", $class);
			$file = __DIR__ . DIRECTORY_SEPARATOR . $basename . ".php";
			if (is_file($file)) {
				try {
					include_once $file;
				} catch (Throwable $e) {
					echo $e;
				}
			}
		}));
		self::$activity = (array) [];
		self::$instance = (object) $this;
	}
	public function __destruct() {
		if (class_exists($index = "activity\index")) {
			self::$activity[$index] = (object) $index;
			$activity = self::$activity[$index]->object = new \activity\index;
			$activity($activity, [], []);
		}
	}
	public function exec(string $filename, array $argv = [], array $envp = []) {

	}
}

class activity {
	protected static $instance;
	public function __invoke(activity $activity, array $argv = [], array $envp = []) {
		self::$instance = $activity;
		if (method_exists($this, "main")) {
			self::$instance::main($argv, $envp);
		}
	}
}

if (!defined("__SYSTEM__")) {
	return new system;
}