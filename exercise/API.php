<?php
	error_reporting(E_ALL ^ E_WARNING); 
    $ebits = ini_get('error_reporting');
    error_reporting($ebits ^ E_NOTICE);

// get api
$content =     file_get_contents("http://www.mocky.io/v2/5af11f8c3100004d0096c7ed");
$result  = json_decode($content);

//echo $_GET["name"] ; 

//get product

$i = 0 ;
while ($i < $result->total ) {
   //echo $i;
  if( $result->data[$i]->id == $_GET["id"] || $result->data[$i]->name  == $_GET["name"] ){

  		$myObj ->id = $result->data[$i]->id ;
  		$myObj ->name = $result->data[$i]->name ;
  		$myObj->image = $result->data[$i]->image ;
  		$myObj ->price = $result->data[$i]->price ;
  		$myObj->in_stock = $result->data[$i]->in_stock ;
  }

 $i++;}


if($_GET["item"] == "number"){ $myObj ->total = $result->total  ; }
if($_GET["item"] == "all"){ $myObj = $result ; }


echo json_encode($myObj);


?>

<!-- wisanu Futemwong -->
