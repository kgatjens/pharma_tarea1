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

//require_once('lib/db.php');
require_once('lib/mongo.php');
error_reporting(-1);
ini_set('display_errors','On');

define("SERVER_PATH",$_SERVER['HTTP_REFERER']); // Temporal
define("FILE_NAME","cleanCsv.csv"); // Temporal

class Pharmacogenomic{

	public $stringToAnalyce;
	public $file_location;
	public $data;



	function __construct($action = "") {
		session_start();
      $this->data = array();

      if(isset($action)){
         switch ($action) {
           case "upload":
              $this->uploadFile();
              break;
          case "all":
              $this->displayAllDrugs();
              unset($_POST);
              break;
          case "add":
              $this->displayAddForm();
              break;
          case "delete":
              $this->deleteDrugs();
              break;
         }
      }

      if(isset($_POST['pharma'])){
         $insertion =  $this->parseFromInsert($_POST);
         if($insertion){
             $message = '<div class="alert alert-success">Se ha ingresado la cadena.</div>';
             include('add.php');
         }
             $message = '<div class="alert alert-danger">Ha ocurrido un error ingresando la secuencia.</div>';
             include('add.php');
      }


       /*if( $_FILES['file']['name'] != "" ){
   
            copy( $_FILES['file']['name'], "/" ) or  die( "Error con Archivo!");

            include('template/success.php');
           
       }*/

		 if(isset($_POST['sequence'])){
       		$this->stringToAnalyce = $_POST['sequence'];
            $this->selectFromCollection($this->stringToAnalyce);
       }
       	//echo SERVER_PATH."/".FILE_NAME;exit;
         $this->readCsv(SERVER_PATH."/".FILE_NAME);
         //$this->selectAll();// Test Function
   	}

   	function readCsv($fileName){
   		set_time_limit(10000000000000000); 
             ini_set('display_errors', 'On');
         // Create a stream
        $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $fileName);

$linesArray = curl_exec($ch);
print_r($linesArray);
    curl_close($ch);

   		//$linesArray = file_get_contents($fileName,false, $context);

   		$this->createSequence($linesArray);
   	}

   	/*
   	*	Read from the file and creates an array with the equence to be analyzed.
   	*
   	*/
   	function createSequence($linesArray = array()){
   		$SequenceDesc=array();
   		$sizes=array();

   		//if(!isset($_SESSION['read_file']) || $_SESSION['read_file']!=1){//read the data file only the first time
	   		foreach ($linesArray as $key => $value) {
	   			$sequence[] = explode(",", $value);
	   		}

	   		foreach ($sequence as $key => $value) {
	   			$sizes[] = explode("[", $value[3]);
	   			$sizes[] = explode("]", $value[3]);

	   			$sequence[$key]['leftHand']     = $sizes[0][0];
	   			$sequence[$key]['originalChar'] = substr($sizes[0][1], 0, 1);//just to get the letter 
	   			$sequence[$key]['wrongChar']    = substr($sizes[0][1], 2, 1);//just to get the letter 
	   			$sequence[$key]['rightHand']    = $sizes[1][1];
	   			unset($sizes);
	   			//$this->show($sizes);//debug
	   		}
	   		
	   		$this->data = $sequence;
   		   $inserted = $this->insertInCollection($this->data);
            
   	}

      /*
      *  Set up the POST array to be added in the collection
      *
      */
      function parseFromInsert($post = ""){
               
         $sizes[] = explode("[", $post['sequense']);
         $sizes[] = explode("]", $post['sequense']);

         $post['leftHand']     = $sizes[0][0];
         @$post['originalChar'] = substr($sizes[0][1], 0, 1);//just to get the letter 
         @$post['wrongChar']    = substr($sizes[0][1], 2, 1);//just to get the letter 
         @$post['rightHand']    = $sizes[1][1];

         //$this->show($post);exit;
         if($post['rightHand'] != ''){ //insert in DB
            return $this->insertSingleCollection($post);
         }else{
            return false;
         }         
      }

      /*
   	*	Consume, and analyze the data to check if que equence is altered or not.
   	*	
      */
   	function checkDirtySequence(){
   		$completeSequence = false;
   		$leftSizeSequence = false;
   		$sequenceData = array();
   		$sequenceDataAlter = array();

   		$i = 0;
        // $this->show($this->data);
      	foreach ($this->data as $key => $value) {
   			$entire 	= $value['leftHand']."[A-Z]".$value['rightHand'];
            $entire = str_replace(array("\r", "\n"), "", $entire);
   			
   			$leftPart 	= $value['leftHand'].$value['originalChar'];
   			$leftPart = str_replace(array("\r", "\n"), "", $leftPart);			

   			if (preg_match("/".$this->stringToAnalyce."/", $entire)) {
               $completeSequence = true;
               
	   		}
	   		if (preg_match("/".$this->stringToAnalyce."/", $leftPart)) {
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
   			
   		}
   		   

   	}


   	/**
   	*    Call the template to display the matches of sequense with no alteration
   	*
   	*/
   	function displaySequenceData($sequenceData = array()){
   		if(count($sequenceData)>0){
   			include('noAlterationTable.php');
   		}
   	}

   	/**
   	*    Call the template to display the matches of sequense with an alteration
   	*
   	*/
   	function displaySequenceDataAlter($sequenceDataAlter = array()){
   		if(count($sequenceDataAlter)>0){
   			include('alterationTable.php');
   		}

   	}

      /**
      * Find a pattern in an expression 
      *
      *
      */
      function selectFromCollection($expression = "", $attribute = ""){
         //$expression = '.*GGCTGAAGTGTTTTACAGGATTTTAA.*';
         $expression = '.*'.$expression.'.*';

         $collection = getMongoConnection();

         $whereNoAlteration=array('originalSequense' => array('$regex'=>$expression));
         $whereAlteration=array('alteredSequense' => array('$regex'=>$expression));
         $cursorNoAlteration = $collection->find($whereNoAlteration);
         $cursorAlteration = $collection->find($whereAlteration);
       
         $total = 0;
         $total = count(iterator_to_array($cursorNoAlteration)) + count(iterator_to_array($cursorAlteration));
         //if($total>0)$total++;
         include('results.php');

         $this->displaySequenceData(iterator_to_array($cursorNoAlteration));
         $this->displaySequenceDataAlter(iterator_to_array($cursorAlteration));

         /*
         $this->show(iterator_to_array($cursorNoAlteration));
         echo ">>><br>";
         $this->show(iterator_to_array($cursorAlteration));
         */         
      }

      /**
      *     Insert into the MongoDb all the sequense data from a read
      *
      */
      function insertInCollection($data = array()){
         $collection = getMongoConnection();
         $error      = array();
         $i = 0;

         foreach ($data as $key => $value) {
              
            $doc['_id']       = $i;
            $doc['pharma']       = $value[0];
            $doc['gene']         = $value[1];
            $doc['snp']          = $value[2];
            $doc['sequense']     = $value[3];
            $doc['metabolizer']  = $value[4];
            $doc['leftHand']     = $value['leftHand'];
            $doc['originalChar'] = $value['originalChar'];
            $doc['wrongChar']    = $value['wrongChar'];
            $doc['rightHand']    = $value['rightHand'];
            $doc['alteredSequense']    = $value['leftHand'].$value['wrongChar'].$value['rightHand'];
            $doc['originalSequense']   = $value['leftHand'].$value['originalChar'].$value['rightHand'];;
            $doc['leftHandChar']       = $value['leftHand'].$value['wrongChar'];

            try {
               $collection->insert( $doc );
            } catch(MongoCursorException $e) {
               $error[$i] = "Error agregando el indice: ".$i;
            }
            $i++;
         }
          
         //$this->show($doc);

         return true;
      }

      /*
      *  Inserting just one sequense
      *
      */
      function insertSingleCollection($data = ""){
             
            $collection = getMongoConnection();
            
            $cursor = $collection->find();
            $id = count(iterator_to_array($cursor));

            
            $doc['_id']          = $id++;
            $doc['pharma']       = $data['pharma'];
            $doc['gene']         = $data['gene'];
            $doc['snp']          = $data['snp'];
            $doc['sequense']     = $data['sequense'];
            $doc['metabolizer']  = $data['metabolizer'];
            $doc['leftHand']     = $data['leftHand'];
            $doc['originalChar'] = $data['originalChar'];
            $doc['wrongChar']    = $data['wrongChar'];
            $doc['rightHand']    = $data['rightHand'];
            $doc['alteredSequense']    = $data['leftHand'].$data['wrongChar'].$data['rightHand'];
            $doc['originalSequense']   = $data['leftHand'].$data['originalChar'].$data['rightHand'];;
            $doc['leftHandChar']       = $data['leftHand'].$data['wrongChar'];

            try {
               $collection->insert( $doc );
               return true;
            } catch(MongoCursorException $e) {
               $error[$i] = "Error agregando el indice: ".$i;
               return false;
            }
         return false;
      }
      

      /*
      *     Select all from the used Mongo Collection and add it to array.
      *
      */
      function displayAllDrugs(){

         $collection = getMongoConnection();
         $data = $collection->find();

         $data = iterator_to_array($data);
         if(count($data)>0){
            include('template/display.php');
         }
      }

      /*
      *     Select all from the used Mongo Collection and add it to array.
      *
      */
      function addCsv(){
         
         $collection = getMongoConnection();
         $data = $collection->find();

         $data = iterator_to_array($data);

         if(count($sequenceData)>0){
            include('noAlterationTable.php');
         }
      }

      /*
      *     Select all from the used Mongo Collection and add it to array.
      *
      */
      function displayAddForm(){
         
         $collection = getMongoConnection();
         $data = $collection->find();

         $data = iterator_to_array($data);

         if(count($sequenceData)>0){
            include('noAlterationTable.php');
         }
      }

      /*
      *     Select all from the used Mongo Collection and add it to array.
      *
      */
      function deleteDrugs(){
         
         $collection = getMongoConnection();
         $data = $collection->find();

         $data = iterator_to_array($data);

         if(count($sequenceData)>0){
            include('noAlterationTable.php');
         }
      }

      /*
      **********************************
      *     HELPERS
      *
      **********************************
      */

      /*
   	* Main display method
   	*  
   	$this->show($value);
   	*/
   	function show($array=array(), $i = 1){
   		echo "Test function:".$i."<br>";
         echo "Total rows: ".count($array)."<br>";
         echo "<pre>";
   		print_r($array);
   		echo "</pre>";
   		//exit;
   	}

      /***
      *  Tester method, 
      *
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
      *     Select all from the used Mongo Collection and show it.
      *
      */
      function selectAll(){
         
         $collection = getMongoConnection();
         $data = $collection->find();

         $this->show(iterator_to_array($data));
      }
      /*
      *  Desc.
      *
      */
      function functionTemplate($a = ""){
         return $a;
      }



}

$main_equence = new Pharmacogenomic(@$action);

?>