<?php

define("PATH_ROOT"      , realpath(dirname(__FILE__) . "/../")   . "/");
define("PATH_CONTROLLER", realpath(PATH_ROOT . "/app/controller") . "/");
define("PATH_PUBLIC"    , realpath(PATH_ROOT . "/public")         . "/");
define("PATH_TEMPLATE"  , realpath(PATH_ROOT . "/app/smarty")     . "/");
define("PATH_LIBS"      , realpath(PATH_ROOT . "/app/libs")       . "/");

define("SITE_NAME_FULL" , "7drg");
define("SITE_NAME_SHORT", "7D");

define("DOMAIN", $_SERVER['SERVER_NAME']);

const config = array(

	//site
	'site_name' => "7th dragon",

	// database
	'db' => array(
		"dbname"  => "drg_dev",
		"server"  => "localhost",
		"user"    => "app",
		"pass"    => "kakukorokorokoro",
		"charset" => "utf8mb4",
		"type"    => "mysql",
	),

	// タグカテゴリ
	'tag_category' => array(
		array('value' => 1, 'key' => "series"),
		array('value' => 2, 'key' => "test"),
	),
);