<?php class activity {
	protected static $instance;
	public function __construct() {
		self::$instance = $this;
		if (method_exists($this, "activity")) {
			self::$instance::activity();
		}
	}
}