<html>
<body>

<h1> Add Contact </h1>

<form action="" method="post">
<br>
Name: <br>
<input type="text" name="FirstName" />
<input type="text" name="LastName" />
<br><br>
E-Mail Address: <input type="text" name="Email" />
<br><br>
Phone Number: <input type="text" name="Phone" />
<br><br><br>
Street Address: <input type="text" name="Street" />
<br><br>
City: <input type="text" name="city" />
<br><br>
State: <input type="text" name="state" />
<br><br>
Zip: <input type="text" name="zip" />
<br><br>
<input type="submit" value="Add Contact" />
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
$formValues = $_POST;
$formErrors = array();
 
print  $_POST['FirstName']."  ".$_POST['LastName'];

$serverName = "SILVERTOASTED";
$connectionInfo = array( "Database"=>"libERATOS");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Could not connect.\n";
     die( print_r( sqlsrv_errors(), true));
}




$sql1 = "INSERT INTO Contact (FirstName, LastName, Email, PhoneNumber, StreetAddress, City, State, Zipcode)
OUTPUT INSERTED.ContactID
          VALUES (?, ?, ?, ?, ?, ? ,? ,?)";

$params1 = array( $_POST['FirstName'],
	          $_POST['LastName'],
	          $_POST['Email'],
	          $_POST['Phone'],
	          $_POST['Street'],
	          $_POST['city'],
	          $_POST['state'],
	          $_POST['zip']
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
      print "<script>window.location='contact.php?cid=".$row['ContactID']."'</script>";
}



}
?>


</body>
</html>