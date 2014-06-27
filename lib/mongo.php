<?php
/**
 * MongoDB Library
 * @Kenneth Brenes
 *  Organization: UCR
 *   
 */

/**
 * File to config the Data Base
 */
require_once 'config.php';

	function getMongoConnection() {

		try 
		{
	      $m = new MongoClient();
	      $db = $m->selectDB('DB_HOST');
	      $collection = new MongoCollection($db, 'DB_COLLECTION');

	      return $collection;
	  	}
	  	catch ( MongoConnectionException $e ) 
		{
		    return false;
		}
	}	


?>