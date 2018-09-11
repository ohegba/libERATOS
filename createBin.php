<html>
<body>

<h1> Create Bin </h1>

<form action="" method="post">
<br>
Bin Name / Short Designation: <br>
<input type="text" name="name" />
<br><br>
Bin Location: <input type="text" name="location" />
<br><br>


<input type="submit" value="Create New Bin" />


</form>



<?php

include "environs.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
$formValues = $_POST;
$formErrors = array();
 
print  $_POST['FirstName']."  ".$_POST['LastName'];

$serverName = $ENV_HOST;
$connectionInfo = array( "Database"=>$ENV_DB);
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Could not connect.\n";
     die( print_r( sqlsrv_errors(), true));
}

$sql1 = "INSERT INTO Bins (BinName, BinLocation)
OUTPUT INSERTED.BinID
          VALUES (?, ?)";

$params1 = array( $_POST['name'],
	          $_POST['location']
	          
);

$stmt1 = sqlsrv_query( $conn, $sql1, $params1 );

if( $stmt1 ) {
     sqlsrv_commit( $conn );
     echo "Transaction committed.<br />";
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
      print "<script>window.location='bin.php?bid=".$row['BinID']."'</script>";
}



}
?>


</body>
</html>