<html>
<form action="" method="post">
<table border="2">
<tr><td>
<strong>Login</strong>
<table border="1">
<tr>
<br>
<td>
User: 
<input type="text" name="usr" size="32" />
</td>
</tr>
<tr>
<td>
Pass: 
<input type="text" name="pwd" size="32" />
</td>
</tr>
</table>
</tr>

</td>
<tr><td align="right">
<input type="submit" value = "Login" size="32" />
</tr></td>
</table>


<?php
include "environs.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
session_destroy();
print  $_POST['usr']."  ".$_POST['pwd'];

$serverName = $ENV_HOST;
$connectionInfo = array( "Database"=>$ENV_DB);
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Could not connect.\n";
     die( print_r( sqlsrv_errors(), true));
}

$tsql = "SELECT * FROM Users WHERE UserName = '".$_POST['usr']."' AND Password = '".$_POST['pwd']."'";
$stmt = sqlsrv_query( $conn, $tsql);

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))
{
      session_start();

if ($row['UserName'] != NULL)
{
      $_SESSION['user'] = $row['UserName'];
      print "<i>Logged in as: ".$_SESSION['user']."</i>";
      ob_start();
      header("Location: index.html"); 
}
else
{ 
    print "Your username or password does not exist in the system. Sorry.";
}


}


}
?>


</html>