<?php

/*
*
*	Class Pharmacogenomic
*	Read sequense of genes, and check if exist an alteration not may cause conflict with some medications.
*	Author: Kenneth Brenes	
*	May, 2014.
*	Organization: UCR
*	https://github.com/kgatjens/....
*
*	git push -u origin 
*
*
*/

require_once('lib/db.php');


define("SERVER_PATH","http://localhost:10088/bio_farma_tarea1/"); // Temporal
define("FILE_NAME","cleanCsv.csv"); // Temporal

class Pharmacogenomic{

	public $stringToAnalyce;
	public $file_location;
	public $data;

	function __construct() {
		session_start();
       	$this->stringToAnalyce = $_POST['sequense'];
       	$this->data = array();
       	$this->readCsv(SERVER_PATH.FILE_NAME);

   	}

   	function readCsv($fileName){
   		$linesArray = file($fileName);
   		$this->createSequense($linesArray);
   	}

   	/*
	*	Read from the file and creates an array with the sequense to be analyzed.
	*
   	*/
   	function createSequense($linesArray = array()){
   		$SequenceDesc=array();
   		$sizes=array();
   		//if(!isset($_SESSION['read_file']) || $_SESSION['read_file']!=1){//read the data file only the first time
	   		foreach ($linesArray as $key => $value) {
	   			$sequense[] = explode(",", $value);
	   		}

	   		foreach ($sequense as $key => $value) {
	   			$sizes[] = explode("[", $value[3]);
	   			$sizes[] = explode("]", $value[3]);

	   			$sequense[$key]['leftHand'] = $sizes[0][0];
	   			$sequense[$key]['originalChar'] = substr($sizes[0][1], 0, 1);//just to get the letter 
	   			$sequense[$key]['wrongChar'] = substr($sizes[0][1], 2, 1);//just to get the letter 
	   			$sequense[$key]['rightHand'] = $sizes[1][1];
	   			unset($sizes);
	   			//$this->show($sizes);//debug
	   		}
	   		//$_SESSION['read_file']=1;
	   		//$this->show($sequense);
	   		$this->data = $sequense;
   		//}
	   	$this->checkDirtySequense();
   	}

   	/*
	*	Consume, and analyze the data to check if que sequense is altered or not.
	*	
   	*/
   	function checkDirtySequense(){
   		$completeSequense = false;
   		$leftSizeSequense = false;
   		$displaySequenseData = array();
   		$displaySequenseDataAlter = array();

		$i = 0;
   		foreach ($this->data as $key => $value) {
   			
   			$entire 	= "/".$value['leftHand']."[A-Z]".$value['rightHand']."/";
   			$entire = str_replace(array("\r", "\n"), "", $entire);
   			
   			$leftPart 	= "/".$value['leftHand'].$value['originalChar']."/";
   			$leftPart = str_replace(array("\r", "\n"), "", $leftPart);			
			
			/*
			echo "<br>";   			
			echo $this->stringToAnalyce;
			echo $i."<br>";
   			echo "<br>";   			
   			*/

   			if (preg_match($entire, $this->stringToAnalyce)) {
		   		$completeSequense = true;
	   		}
	   		if (preg_match($leftPart, $this->stringToAnalyce)) {
		   		$leftSizeSequense = true;

	   		}
	   		
	   		/*
	   		echo "entra3";
	   		$this->show($this->data);
	   		*/

			if($completeSequense && $leftSizeSequense){ // no alteration
				$displaySequenseData[$i]['pharma']	= $value[0];
				$displaySequenseData[$i]['gene']	= $value[1];
				$displaySequenseData[$i]['snp']		= $value[2];
				$displaySequenseData[$i]['sequense']= $value[3];
				$displaySequenseData[$i]['alteration']= 'false';
			}else if($completeSequense){// complete gene with an alteration
				$displaySequenseDataAlter[$i]['pharma']		= $value[0];
				$displaySequenseDataAlter[$i]['gene']		= $value[1];
				$displaySequenseDataAlter[$i]['snp']		= $value[2];
				$displaySequenseDataAlter[$i]['sequense']	= $value[3];
				$displaySequenseDataAlter[$i]['alteration']	= 'true';
			}
			else{ // not any gene

			}
			$completeSequense = $leftSizeSequense = false;
			$i++;
   			/*$value['leftHand'] 
   			$value['originalChar']
   			$value['rightHand']*/

   			// The "i" after the pattern delimiter indicates a case-insensitive search
			//if (preg_match("/php/i", "PHP is the web scripting language of choice.")) {
   		}
   		//$this->stringToAnalyce;
   		$this->show($displaySequenseData);
   	}


   	/***
	Test method

   	*/
   	function testCase(){

   		$a = 'ACTGCTTCAGTTCCAACAACGACGC';
   		$b = 'C';
   		$c = 'CCATAAATTACATGAGTACCTTAGT';

   		$ch = 'ACTGCTTCAGTTCCAACAACGACGCCCCATAAATTACATGAGTACCTTAGT';


   		$m = 'ACTGCTTCAGTTCCAACAACGACGCMCCATAAATTACATGAGTACCTTAGT';
		echo $exp = "/".$a.$b."/";
		echo $exp2 = "/".$a."[A-Z]".$c."/";
		echo "<br>";
   		if (preg_match($exp2, $m)) {
   			echo "yes";
   		}else{echo "no";}
   	}

   	/*
	* 		- HELPER
	*  
	$this->show($value);
	*/
	function show($array=array()){
		echo "<pre>";
		print_r($array);
		echo "</pre>";
		exit;
	}

}

$main_sequense = new Pharmacogenomic();

?>