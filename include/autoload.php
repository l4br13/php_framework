<?php
final class autoload {
	protected $function;
	public function register(int|string $id, callable $function) {
		if (isset($this->function[$id])) {
			return false;
		}
		$this->function[$id] = $function;
		return spl_autoload_register($this->function[$id]);
	}
	public function unregister(int|string $id) {
		if (!isset($this->function[$id])) {
			return false;
		}
		return spl_autoload_unregister($this->function[$id]);
	}
}

if (defined("AUTOLOAD")) {
	return false;
} else {
	define("AUTOLOAD", __FILE__) || exit;
}

return new class {
	protected $main;
	protected $autoload;
	public function __construct() {
		($this->autoload = new autoload)->register(0, function (string $class) {
			$filename = __DIR__ . DIRECTORY_SEPARATOR . str_replace("\\", ".", $class) . ".php";
			if (!class_exists($class)) {			
				try {
					if (is_file($filename)) {
						include_once $filename;
					}
				} catch (Throwable $e) {
					echo $e;
				}
			}
		});
	}
	public function __destruct() {
		if (class_exists("\index\main")) {
			$this->main = new \index\main;
		}
	}
};