<?php

include "skutize.php";
include "environs.php";

function UIEEHeader()
{

print "UserID"."\r\n";
print "BOOKS"."\r\n";
print  date("m-d-Y", time())."\r\n";
print  date("H:i:s", time())."\r\n";

print "\r\n";

}



function UIEE($sid)
{

global $ENV_HOST, $ENV_DB;

$serverName = $ENV_HOST;
$connectionInfo = array( "Database"=>$ENV_DB);
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn === false )
{
     echo "Could not connect.\n";
     die( print_r( sqlsrv_errors(), true));
}

$sql1 = "SELECT *, condie.ConditionDesc  as [CCondition], bender.BindingDesc  as [CBinding] FROM SPECIMENS 
LEFT JOIN Conditions condie on condie.ConditionID = ChooseCondition
LEFT JOIN Bindings bender on bender.BindingID = ChooseBinding
WHERE SpecimenID = ".$sid;

$stmt1 = sqlsrv_query( $conn, $sql1 );



while( $row = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC))
{
      $specimen = $row;
}

header('Content-type: text/plain');
header("Content-disposition: attachment; filename=\"".date("m-d-Y H:i:s", time()).".UIEE\"");

$actionCode = 1;

$AUTHs = explode(";", $specimen['Authors']);

$KWs = explode(";", $specimen['Keywords']);

if ($specimen['Price'] < 1 || $specimen['Price'] == NULL)
	$specimen['Price'] = 0.00;

$unit = 1;

print "UR|".DBsku($specimen['SpecimenID'])."\r\n";
foreach ($AUTHs as &$author) 
{
      print "AA|".$author."\r\n";
}
print "TI|".$specimen['Title']."\r\n";
print "CN|".$specimen['CCondition']."\r\n";
print "PU|".$specimen['Publisher']."\r\n";
print "PP|".$specimen['PubLoc']."\r\n";
print "DP|".$specimen['PubYear']."\r\n";
print "BD|".$specimen['CBinding']."\r\n";
if ($specimen['Keywords'] != null)
foreach ($KWs as &$key) 
{
      print "KE|".$key."\r\n";
}
//print "JK|".$specimen['JacketCond']."\r\n";
print "CO|".$unit."\r\n";
print "NT|".$specimen['ISBN']."\r\n";
print "PR|".number_format($specimen['ListingPrice'],2)."\r\n";
print "XB|".$actionCode."\r\n";
print "\r\n";

}

?>