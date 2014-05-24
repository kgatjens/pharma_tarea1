<?php
/**
 * Cofig File
 *
 * Contains:
 *  - Date
 *  - Data Base
 *  
 */

// http://www.php.net/manual/en/timezones.php
date_default_timezone_set('America/Costa_Rica');
error_reporting(E_ALL);//debug

// Config Data Base info

define("DB_NAME","bio");
define("DB_HOST","127.0.0.1");
define("DB_USER","root");
define("DB_PASS","");

/*
$configDB = array(
    'host'    	=> '127.0.0.1',
    'user' 		=> 'root',
    'pass'   	=> '',
    'schema' 	=> 'bio',
);*/

