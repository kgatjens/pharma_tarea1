<?php

/*
*
*	Class Pharmacogenomic
*	Read equence of genes, and check if exist an alteration not may cause conflict with some medications.
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
error_reporting(-1);
ini_set('display_errors','On');

define("SERVER_PATH",$_SERVER['HTTP_ORIGIN']); // Temporal
define("FILE_NAME","cleanCsv.csv"); // Temporal

class Pharmacogenomic{

	public $stringToAnalyce;
	public $file_location;
	public $data;

	function __construct() {
		session_start();
		if(isset($_POST['sequence'])){
       		$this->stringToAnalyce = $_POST['sequence'];
       	}
       	$this->data = array();
       	$this->readCsv(SERVER_PATH."/farmacogenomica/".FILE_NAME);

   	}

   	function readCsv($fileName){

   		echo $fileName."<br>";
   		$linesArray = file($fileName);

   		   		$this->show($linesArray);
echo "dsfd";
   		$this->createequence($linesArray);
   	}

   	/*
	*	Read from the file and creates an array with the equence to be analyzed.
	*
   	*/
   	function createequence($linesArray = array()){
   		$SequenceDesc=array();
   		$sizes=array();
   		//if(!isset($_SESSION['read_file']) || $_SESSION['read_file']!=1){//read the data file only the first time
	   		foreach ($linesArray as $key => $value) {
	   			$sequence[] = explode(",", $value);
	   		}

	   		foreach ($sequence as $key => $value) {
	   			$sizes[] = explode("[", $value[3]);
	   			$sizes[] = explode("]", $value[3]);

	   			$sequence[$key]['leftHand'] = $sizes[0][0];
	   			$sequence[$key]['originalChar'] = substr($sizes[0][1], 0, 1);//just to get the letter 
	   			$sequence[$key]['wrongChar'] = substr($sizes[0][1], 2, 1);//just to get the letter 
	   			$sequence[$key]['rightHand'] = $sizes[1][1];
	   			unset($sizes);
	   			//$this->show($sizes);//debug
	   		}
	   		//$_SESSION['read_file']=1;
	   		$this->show($sequence);
	   		echo "desplegando secuencia";
	   		$this->data = $sequence;
   		//}
	   	$this->checkDirtyequence();
   	}

   	/*
	*	Consume, and analyze the data to check if que equence is altered or not.
	*	
   	*/
   	function checkDirtyequence(){
   		$completeSequence = false;
   		$leftSizeSequence = false;
   		$sequenceData = array();
   		$sequenceDataAlter = array();

		$i = 0;
   		foreach ($this->data as $key => $value) {
   			
   			$entire 	= "/".$value['leftHand']."[A-Z]".$value['rightHand']."/";
   			$entire = str_replace(array("\r", "\n"), "", $entire);
   			
   			$leftPart 	= "/".$value['leftHand'].$value['originalChar']."/";
   			$leftPart = str_replace(array("\r", "\n"), "", $leftPart);			

   			if (preg_match($entire, $this->stringToAnalyce)) {
		   		$completeSequence = true;
	   		}
	   		if (preg_match($leftPart, $this->stringToAnalyce)) {
		   		$leftSizeSequence = true;
	   		}

			if($completeSequence && $leftSizeSequence){ // no alteration
				$sequenceData[$i]['pharma']		= $value[0];
				$sequenceData[$i]['gene']		= $value[1];
				$sequenceData[$i]['snp']		= $value[2];
				$sequenceData[$i]['sequence']	= $value[3];
				$sequenceData[$i]['alteration']	= 'false';
			}else if($completeSequence){// complete gene with an alteration
				$sequenceDataAlter[$i]['pharma']		= $value[0];
				$sequenceDataAlter[$i]['gene']			= $value[1];
				$sequenceDataAlter[$i]['snp']			= $value[2];
				$sequenceDataAlter[$i]['sequence']		= $value[3];
				$sequenceDataAlter[$i]['alteration']	= 'true';
			}
			else{ // not any gene

			}
			$completeSequence = $leftSizeequence = false;
			$i++;
   			/*$value['leftHand'] 
   			$value['originalChar']
   			$value['rightHand']*/
   			
   		}
   		   	
   		   	//$this->show($sequenceData);

   			$this->displaySequenceData($sequenceData);
   			$this->displaySequenceDataAlter($sequenceDataAlter);
   	}


   	/**
	*
	*
   	*/
   	function displaySequenceData($sequenceData = array()){
   		if(count($sequenceData)>0){
   			include('noAlterationTable.php');
   		}
   	}

   	/**
	*
	*
   	*/
   	function displaySequenceDataAlter($sequenceDataAlter = array()){
   		if(count($sequenceDataAlter)>0){
   			include('alterationTable.php');
   		}

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

$main_equence = new Pharmacogenomic();

?>