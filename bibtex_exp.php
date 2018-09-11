<?php

include "environs.php";
include "skutize.php";

function bibtexdump($sid)
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

print "@BOOK{".dbSKU($specimen['SpecimenID']).",<br>";

print "author      = \"".$specimen['Authors']."\",<br>";
print "title      =\"".$specimen['Title']."\",<br>";
print "publisher      =\"".$specimen['Publisher']."\",<br>";
print "year      =\"".$specimen['PubYear']."\",<br>";
print "address      =\"".$specimen['PubLoc']."\"";
print "<br>";
print "}<br>";


}








?>