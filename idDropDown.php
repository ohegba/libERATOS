<?php


function printDropDown($ddName, $db, $host, $query, $valCol, $capCol)
{


$serverName = $host;
$connectionInfo = array( "Database"=>$db);
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Could not connect.\n";
     die( print_r( sqlsrv_errors(), true));
}

$stmt = sqlsrv_query( $conn, $query);
print "<select name = \"".$ddName."\">";

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
{
    $id = $row[$valCol];
   $text = $row[$capCol];

    print "<option value=\"".$id."\">".$text."</option>";

}


print "</select>";


}



function printDropDownDefToKnown($ddName, $db, $host, $query, $valCol, $capCol, $def)
{


$serverName = $host;
$connectionInfo = array( "Database"=>$db);
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Could not connect.\n";
     die( print_r( sqlsrv_errors(), true));
}

$stmt = sqlsrv_query( $conn, $query);
print "<select autocomplete=\"off\" name = \"".$ddName."\">";

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
{
    $id = $row[$valCol];
   $text = $row[$capCol];

    print "<option ";
    
    if ($id == $def)
{
    print " selected=\"selected\" ";
}


    print "value=\"".$id."\">".$text."</option>";

}


print "</select>";


}







?>