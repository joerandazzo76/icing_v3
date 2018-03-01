<?php

class DB
{
	private static $instance = NULL;
	
	private function __construct()
	{
	}
	
	public static function getInstance()
	{
		
		if (!self::$instance) {
			self::$instance =
				new PDO("" . getEnv('DB_TYPE') . ":host=" . getEnv('LOCALHOST') . ";dbname=" . getEnv('DB_NAME') . "", getEnv('DB_USERNAME'), getEnv('DB_PASSWORD'));
			self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		return self::$instance;
	}
	
}