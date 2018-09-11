<html>
<body>

<?php

include "environs.php";
include "skutize.php";

if ( isset ($_GET['bid']) ) 
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

$tsql = "SELECT * FROM Bins WHERE BinID = ".$_GET['bid'];
$stmt = sqlsrv_query( $conn, $tsql);

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
{     print "<h1>Bin #".$row['BinID']."</h3>";
      print "<h4>Phys Loc:".$row['BinLocation']."</h2>";
      print "<h3>Friendly Desig: ".$row['BinName']."</h1>";
     
}


$tsql = "SELECT * FROM Specimens WHERE BinID = ".$_GET['bid'];
$stmt = sqlsrv_query( $conn, $tsql);

print "<table width=\"100%\" ><th>Books</th><tr><td>Title</td><td>SKU</td><td>SID</td></tr>";

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
{
      print "<tr><td>";
	  
	  print "<big><a href=\"specimen.php?sid=".$row["SpecimenID"]."\">".$row['Title']."</a></big>";
	  
	  print "</td><td>".DBsku($row["SpecimenID"])."</td><td>".$row["SpecimenID"]."</td></tr>";
}

print "</table>";



}

?>


</body>
</html>