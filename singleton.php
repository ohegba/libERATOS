<?php

function SingletonInsertSQL($db, $host, $query, $params, $outputCol)
{


$serverName = $host;
$connectionInfo = array( "Database"=>$db);
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Could not connect.\n";
  
}


$sql1 = $query;
$params1 = $params;

$stmt1 = sqlsrv_query( $conn, $sql1, $params1 );

if( $stmt1 ) {
     sqlsrv_commit( $conn );
    
} else {
     
 if( ($errors = sqlsrv_errors() ) != null) {
        foreach( $errors as $error ) {
            echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
            echo "code: ".$error[ 'code']."<br />";
            echo "message: ".$error[ 'message']."<br />";
        }
    }
     sqlsrv_rollback( $conn );
     echo "Transaction rolled back.<br />";
}

while( $row = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC))
{
      return $row[$outputCol];
}


}


function GetFirstSQLRow($db, $host, $query, $params)
{


$serverName = $host;
$connectionInfo = array( "Database"=>$db);
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Could not connect.\n";
  
}


$sql1 = $query;
$params1 = $params;

$stmt1 = sqlsrv_query( $conn, $sql1, $params1 );

if( $stmt1 ) {
     sqlsrv_commit( $conn );
    
} else {
     
 if( ($errors = sqlsrv_errors() ) != null) {
        foreach( $errors as $error ) {
            echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
            echo "code: ".$error[ 'code']."<br />";
            echo "message: ".$error[ 'message']."<br />";
        }
    }
     sqlsrv_rollback( $conn );
     echo "Transaction rolled back.<br />";
}

while( $row = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC))
{
      return $row;
}


}


?>