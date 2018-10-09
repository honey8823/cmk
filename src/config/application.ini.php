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

	// twitter oauth
	'twitter_oauth' => array(
		'api_key'      => "uiawgD3A3nuQvRkk3SnLg",
		'api_secret'   => "DYW4PYLT7hZJgsUbQVFyBqnxr0KRzPL3KHyPNglCc",
		'callback_url' => "",
	),

	// シリーズ
	'series' => array(
		'1' => array('name' => "(無印)"  , 'name_short' => "-"),
		'2' => array('name' => "2020"    , 'name_short' => "2020"),
		'3' => array('name' => "2020-Ⅱ" , 'name_short' => "2021"),
		'4' => array('name' => "Ⅲ"      , 'name_short' => "3"),
	),
);