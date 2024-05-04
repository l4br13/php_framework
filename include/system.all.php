<?php
namespace {
	use system\autoload;
	final class system {
		protected $autoload;
		protected static $instance;
		public function __construct() {
			defined("index") OR exit;
			!defined("system") OR exit;
			define("system_root", dirname(index));
			define("dir_separator", DIRECTORY_SEPARATOR);
			define("system_autoload",$this->autoload = new autoload);
			$this->autoload->register(0, function (string $class) {
				$filename = str_replace("\\", ".", $class);
				$files = __DIR__ . DIRECTORY_SEPARATOR . $filename . ".php";
				if (is_file($files)) {
					try {
						include_once $files;				
					} catch (Throwable $e) {
						echo $e;
					}
				}
			});
			self::$activity = (array) null;
			self::$instance = $this;
		}
		public function __destruct() {
			if (isset(self::$instance)) {
				if (class_exists("activiy\index")) {
					$index_activity = new \activity\index;
				}
			}
		}
	}

	if (!defined("system")) {
		return new system;
	}
}

namespace system {
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
}

namespace system {
	final class env {
		protected static $var;
		protected static $instance;
		public function __construct() {
			if (!isset(self::$instance)) {
				self::$var = (array) [];
				self::$instance = $this;
			}
		}
	}
}