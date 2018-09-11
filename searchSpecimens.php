<style>
body {background-color:#F7F7C5;}
</style>


<?php



include 'util.php'; 
include "singleton.php";
include "environs.php";
include "skutize.php";

//if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

 

$_REQUEST['searchText'] = str_replace(":", "", $_REQUEST['searchText']);

$serverName = $ENV_HOST;
$connectionInfo = array( "Database"=>$ENV_DB);
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn === false )
{
     echo "Could not connect.\n";
     die( print_r( sqlsrv_errors(), true));
}

$srch = $_REQUEST['searchText'];

$recCount = SingletonInsertSQL($ENV_DB, $ENV_HOST,  

"SELECT COUNT(*) AS [Count] FROM Specimens WHERE (SOUNDEX(Title) = SOUNDEX( '".$_REQUEST['searchText']."') OR SOUNDEX(Authors) = SOUNDEX('".$_REQUEST['searchText']."') OR Title LIKE '%".$srch."%' OR Authors LIKE '%".$srch."%' OR ISBN LIKE '%".$srch."%')"
,
 null, "Count")

;



$pageNum = $_GET['pg'];

if ($pageNum < 1)
$pageNum = 1;

$recInt = 7;
$recStart = ($pageNum - 1) * ($recInt) + 1;

$recEnd = ($recStart + $recInt) - 1;



$tsql = "
WITH Results AS
(

SELECT *, ROW_NUMBER() OVER (ORDER BY Title) as 'RowNum' FROM Specimens WHERE (SOUNDEX(Title) = SOUNDEX( '".$_REQUEST['searchText']."') OR SOUNDEX(Authors) = SOUNDEX('".$_REQUEST['searchText']."') OR Title LIKE '%".$srch."%' OR Authors LIKE '%".$srch."%' OR ISBN LIKE '%".$srch."%')

)

SELECT * FROM Results
WHERE RowNum BETWEEN ".$recStart." AND ".$recEnd.""


;



$stmt = sqlsrv_query( $conn, $tsql);

print "<h1>Search Results</h1><br>";

$var = 0;

print '<form action="resultsAction.php" method="POST">';

print "<table width=\"100%\" style=\"border:2px solid black;\" bgcolor=\"#dddddd\">";
print "<tr bgcolor=\"#aaaaaa\"><td> </td> <td> Title </td> <td> SKU </td><td> ISBN </td><td> Sold? </td> </tr>";

$everyOtherRow = false;
 
$rowAColor = " bgcolor=\"#ffffff\" ";
$rowBColor = " bgcolor=\"#d5e5ff\"";

$rowColor = "";

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
{

$rowColor = ($everyOtherRow==true) ? $rowAColor : $rowBColor;



print "<tr ".$rowColor.">";

print "<td><input type=\"checkbox\" name=\"recCheck[]\" value=\"".$row['SpecimenID']."\" > </td>";



print "<td><br><a href=\"specimen.php?sid=".$row['SpecimenID']."\">".$row['Title']." </a></td>";

print "<td>".DBsku($row["SpecimenID"])."</td>";

print "<td>".$row['ISBN']."</td>";

print "<td>".YesNo($row['Sold'])."</td>";



print " </tr>";

$everyOtherRow = !$everyOtherRow;

$var++;
}

print "</table>";

print "<br>";

print '<input type="submit" name="batchUIEE" value="Batch UIEE">';
print '<input type="submit" name="batchbib" value="Batch BibTeX">';

print '</form>';

print "".$recCount." records found.";
print "<br>Showing ".$recInt. " records per page.";

print "<br><br>";

for ($i = 1; $i <= (($recCount / $recInt) + 1); $i++)
{
   print "<a href=searchSpecimens.php?pg=".$i.">".$i."</a>  &nbsp ";
} 



}
?>


<br><br>
<a href="index.html"> <strong> Back to libERATOS Home! </strong> </a>