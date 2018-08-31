
<head>
<meta charset="UTF-8">
</head>
<?php

    $ebits = ini_get('error_reporting');
    error_reporting($ebits ^ E_NOTICE);

    //input  edit
   $coin=$_POST['coin'];
   $product=$_POST['product'];

    // get Total
$i = 0 ;
$temp = 0 ;
while ( $coin[$i] != Null ) {
//echo $i;
    if(is_numeric($coin[$i])){     
        $temp = $temp + $coin[$i] ;
        if($coin[$i] == 0 ){
          $temp = $temp + 9 ;
        }
    }
$i++;
}

$Total = $temp ;
//echo $Total."\n";


// get api
$content =     file_get_contents("http://localhost/test/API.php?item=number");
$result  = json_decode($content);
$itemtotal = $result->total ;
//echo $itemtotal;

//  Name product edit with API
$i = 0 ;$l = 0;
while ($product[$i] != null ) {
  if($product[$i] !=' '){$NameproductAPI[$l] = $product[$i]; $l++; }else{ $NameproductAPI[$l] = '%'; $l++; $NameproductAPI[$l] = '2'; $l++; $NameproductAPI[$l] = '0'; $l++; }
  $i++;
}

//echo implode("",$NameproductAPI);
$content =     file_get_contents("http://localhost/test/API.php?name=".implode("",$NameproductAPI));
$result  = json_decode($content);
//echo $result->name;

//get product
$i = 0 ;
$Gotitem = null ;
$Selected = null ;
$NumArr = null ;
while ($i < $itemtotal) {

  if( $result->name  == $product  ){
  
    if ( ( $result->price  <= $Total ) && ($result->in_stock === true ) )
    {
     // echo "T1 "; 
      $Gotitem = true ;
      $Selected = $product ;
      $NumArr = $i;
      break;

    }else{
      //echo "F2 ";
      $Gotitem = false ;
      $Selected = $product ;
      $NumArr = $i;
      break;
    }
  }

 $i++;}

if($i == 6 && $Gotitem == null && $Selected == null)
  {
    //echo "F3 " ; 
    $Gotitem = false ; $Selected = '-' ;
    $NumArr = Null;
  }


////// Change //////
if($Gotitem == true){
    $TotalChange = $Total - ($result->price) ;
    //echo $TotalChange;
  }else{ // Gotitem is false Selected is -
    $TotalChange = $Total ;
    //echo $TotalChange;
  }

$ChangeCoin = null ;
$i = 0 ;
while ($TotalChange > 0) {

if($TotalChange >= 10 ){ $ChangeCoin[$i] = 10 ; $TotalChange = $TotalChange - 10 ; }
else{
    if($TotalChange >= 5 ){ $ChangeCoin[$i] = 5 ; $TotalChange = $TotalChange - 5 ; }
    else{
        if($TotalChange >= 2 ){ $ChangeCoin[$i] = 2 ; $TotalChange = $TotalChange - 2 ; }
        else{
            if($TotalChange >= 1 ){ $ChangeCoin[$i] = 1 ; $TotalChange = $TotalChange - 1; }
            }
        }
    }
$i++;
}
//print_r( $ChangeCoin );

//show ui

 echo "<br/>";
 echo "Insert : ".$coin."<br/>";
 echo "Total : ".$Total."<br/>";
 echo "Selected : ".$Selected."<br/>";
 echo "Got item : ".($Gotitem ? 'true' : 'false')."<br/>";

// show Change and refund

$StringChangeCoin = null ;
$i = 0; 

while(!is_null($ChangeCoin[$i])){
    $StringChangeCoin = $StringChangeCoin.$ChangeCoin[$i] ; 
    if(!is_null($ChangeCoin[$i+1]))
      {$StringChangeCoin = $StringChangeCoin.','; } 
$i++;}

 if($Gotitem === true ){ echo "Change : ".$StringChangeCoin; }
 else{ echo "<button onclick=".'"'."myFunction()".'"'.">refund</button>"; }


?>

<br>
<img src="<?php echo $result->data[$NumArr]->image; ?>"> 

<script type="text/javascript">
  
function myFunction() {
    alert("<?php echo $StringChangeCoin ?>");
}
</script>

<?php



//$content = file_get_contents("http://localhost/test/API.php?name=".$product);

//$result  = json_decode($content);

//print_r($result );
//echo $result ->name;
?>
<!-- wisanu Futemwong -->
