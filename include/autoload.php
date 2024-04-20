<?php
final class autoload {
	protected $enabled = true;
	protected $function;
	public function enable() {
		if ($this->enabled == true) {
			return $this->enabled;
		}
		foreach ($this->function as $key => $value) {
			spl_autoload_register($this->function[$key]);
		}
		return $this->enabled = true;
	}
	public function disable() {
		if ($this->enabled == false) {
			return false;
		}
		foreach ($this->function as $key => $value) {
			spl_autoload_unregister($this->function[$key]);
		}
		$this->enabled = false;
		return true;
	}
	public function register(int|string $id, callable $function) {
		if (isset($this->function[$id])) {
			return false;
		}
		$this->function[$id] = $function;
		if ($this->enabled == true) {
			return spl_autoload_register($this->function[$id]);
		}
		return true;
	}
	public function unregister(int|string $id) {
		if (!isset($this->function[$id])) {
			return false;
		}
		if ($this->enabled == true) {
			return spl_autoload_unregister($this->function[$id]);
		}
		return true;
	}
}

if (!defined("__AUTOLOAD__")) {
	error_reporting(0);
	global ${md5(__FILE__)};
	$autoload = new autoload;
	$autoload->register(0, function (string $class) {
		$filename = str_replace("\\", ".", $class);
		$files = __DIR__ . DIRECTORY_SEPARATOR . $filename . ".php";
		if (is_file($files)) {
			try {
				require_once $files;				
			} catch (Throwable $e) {
				echo $e;
			}
		}
	});
	${md5(__FILE__)} = $autoload;
	return (string) md5(__FILE__);
}