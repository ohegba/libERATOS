<html>
<body>

<?php

include "environs.php";

if ( isset ($_GET['cid']) ) 
{

define('DESIRED_DATE_FORMAT','m/d/y');

$serverName = $ENV_HOST;
$connectionInfo = array( "Database"=>$ENV_DB);
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Could not connect.\n";
     die( print_r( sqlsrv_errors(), true));
}

$tsql = "SELECT * FROM Contact WHERE ContactID = ".$_GET['cid'];
$stmt = sqlsrv_query( $conn, $tsql);

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
{
      print "<h1>".$row['FirstName']." ".$row['LastName']."</h1>";
      print "<br>"."Email".": ".$row['Email']."";
      print "<br>"."Phone".": ".$row['PhoneNumber']."";
      print "<br>";
      print "<br>"."Address:";
      print "<br>".$row['StreetAddress']."<br>".$row['City'].",&nbsp ".$row['State']."  ".$row['Zipcode'];
}




}

?>


</body>
</html>