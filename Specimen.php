<html>
<body>

<div style="border:2px solid black;">

<style>
p
{
width:100%;
}
div
{
padding-left: 2%;
width:50%;
}
body {background-color:#F7F7C5;}
</style>

<?php

include "environs.php";

include "skutize.php";

if ( isset ($_GET['sid']) ) 
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

$tsql = "SELECT *, condie.ConditionDesc as [CCondition],
bender.BindingDesc as [CBinding]
FROM Specimens
LEFT JOIN Conditions condie on condie.ConditionID = ChooseCondition
LEFT JOIN Bindings bender on bender.BindingID = ChooseBinding
WHERE SpecimenID = ".$_GET['sid']
;


$stmt = sqlsrv_query( $conn, $tsql);

$lastArray;
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
{
      
$lastArray = $row;



      print "<h3>Specimen # ".$row['SpecimenID']."</h3>";

if ($row['ISBN'] == NULL)
$row['ISBN'] = "NO ISBN!";

      print "<h2><i>".$row['Title']."</i>&nbsp&nbsp(".$row['ISBN'].") "."</h2>";
 
      print "<b>SKU</b> &nbsp &nbsp".DBsku($row['SpecimenID'])."";
    //  print "<table style=\"border:2px solid black;\"><tr><td>";



if ($row["BinID"] != NULL)
{
 print "&nbsp&nbsp&nbsp<b>Location</b>&nbsp&nbsp";
 print "<a href=bin.php?bid=".$row['BinID'].">".$row['BinID']."</a>";
}

      print "<br><br><b>Authors</b><br>";

      $AUTHs = explode(";", $row['Authors']);



    foreach ($AUTHs as &$author) 
    {
      print "<br> &nbsp &nbsp &nbsp".$author;
    }



      print "<br><br><b>Publisher</b><br>";
      print $row['Publisher'];
      print "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp".$row['PubLoc'];
      print "&nbsp&nbsp&nbsp".$row['PubYear'];

      print "<br><br><b>Extra Info</b><br>";
      print "".$row['Pages']." pages;";
      print "&nbsp".$row['CBinding']." ";

    //   print "</table></tr></td>";

      print "<br><br><b>Condition</b><br>";
      print "<p>".$row['CCondition']."<p>";

      print "<br><br><b>Listing Price</b><br>";
      print "<p>$".number_format($row['ListingPrice'],2)."<p>";

      print "<br><br><b>Comments</b><br>";
      print "<p width=\"95%\">".$row['Comments']."<p>";

    print "<b>Keywords</b><br>";
    $KEYs = explode(";", $row['Keywords']);

    foreach ($KEYs as &$key) 
    {
      print "<br> &nbsp &nbsp &nbsp".$key;
    }



       print "<br><a href=\"editSpecimen.php?sid=".$row['SpecimenID']."\">(edit)</a>";

}




}

?>

</div>
<br><br>
<a href=<?php print "\"specimenUIEE.php?sid=".$lastArray['SpecimenID']."\""; ?>><b>Download UIEE Record</b></a>
<br><br>
<a href=<?php print "\"isbn.php?isbn=".$lastArray['ISBN']."\""; ?>><b>ISBN Info, Barcode & Price Comparison</b></a>
<br>
<a href="index.html"><b>Back to libERATOS Home!</b></a>

</body>
</html>