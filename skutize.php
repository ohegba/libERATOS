<?php

include "environs.php";

//print VIEWaSKU("The Merchant of Venice", "Shaky Willy");
//print "<br><br><br>DONE";

function stripSpaces($str)
{

   return preg_replace('/\s+/', '', $str);


}

function startsWith($needle, $haystack)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function DBsku($sid)
{
global $ENV_DB, $ENV_HOST;
$serverName = $ENV_HOST;
//print $ENV_DB."!";
$connectionInfo = array( "Database"=> $ENV_DB);
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Could not connect.\n";
     die( print_r( sqlsrv_errors(), true));
}

$tsql = "SELECT *, condie.ConditionSKUCode as [CCondition],
bender.BindingDesc as [CBinding]
FROM Specimens
LEFT JOIN Conditions condie on condie.ConditionID = ChooseCondition
LEFT JOIN Bindings bender on bender.BindingID = ChooseBinding
WHERE SpecimenID = ".$sid
;

$stmt = sqlsrv_query( $conn, $tsql);

$lastArray;
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
{
      
        $sku = strtoupper(findFirstN2(stripSpaces(preg_replace("/[^A-Za-z0-9 ]/", '', $row['Title'])), 5));

 $AUTHs = explode(";", $row['Authors']);

$leadAuth;
    foreach ($AUTHs as &$author) 
    {
      $leadAuth = $author;
break;
    }

        $sku = $sku.strtoupper(findFirstN2(stripSpaces(getTheLastWord(preg_replace("/[^A-Za-z0-9 ]/", '', $leadAuth))), 5));
        if ($row['ISBN'] == null || strlen($row['ISBN']) < 4)
        $sku = $sku."0000";
	else
        $sku = $sku.substr($row['ISBN'], strlen($time)-4, 4 );
        if ($row['CCondition'] == null || strlen($row['CCondition']) < 3)
        $sku = $sku."UNK";
else
        $sku = $sku.$row['CCondition'];
        return $sku."";

}


	
}

function VIEWaSKU($title, $author)
{
	$sku = strtoupper(findFirstN2(stripSpaces($title), 4));
        $sku = $sku.strtoupper(findFirstN2(stripSpaces(getTheLastWord($author)), 4));
        return $sku;
}


function findFirstN2($str, $n)
{

     $offset = 0;
     $strcm =  "The";
     $str = str_pad($str, $n, "X", STR_PAD_RIGHT);
    // print "Compare".$str." ".$strcm."<br>";
     while (startsWith($strcm, $str))
     {
         $str = str_pad(substr($str, $n-2), $n, "X", STR_PAD_RIGHT);
     }

     return substr($str,0,$n);
	

}

function getTheLastWord($txt)
{
        $out=preg_split('/\s+/',trim($txt)); 
	return $out[count($out)-1]; 
}

function findFirstN($str, $n)
{

     $offset = 0;
     $strcm =  str_pad("The", $n, "X", STR_PAD_RIGHT);
     $str = str_pad($str, $n, "X", STR_PAD_RIGHT);

    // print "Compare".$str." ".$strcm."<br>";
     while (substr_compare($str, substr($strcm, 0, $n), $offset, $n, true) == 0)
     {
	 $offset = $offset + $n;
         $str = str_pad($str, $n + $offset, "X", STR_PAD_RIGHT);


	

     }

     return substr($str, $offset, $n);
	

}


?>