<?php session_start();?>

<html>
<body>

<?php

include "idDropDown.php";
include "singleton.php";
include "environs.php";


$usrName = $_SESSION['user'];
if ($usrName == null)
{
   print "You can't add inventory while not logged in!";   
   ob_start();
   header("Location: index.html");
   print "You can't add inventory while not logged in!"; 
}
?>


<script>

function RUNwc()
{

var ISBN = document.forms["formi"]["isbn"].value;
window.location.href = "runWC.php?isbn="+ ISBN; 

}

</script>

<script language="JavaScript">
<!--
function FP_openNewWindow(w,h,nav,loc,sts,menu,scroll,resize,name,url) {//v1.0
 var windowProperties=''; if(nav==false) windowProperties+='toolbar=no,'; else
  windowProperties+='toolbar=yes,'; if(loc==false) windowProperties+='location=no,'; 
 else windowProperties+='location=yes,'; if(sts==false) windowProperties+='status=no,';
 else windowProperties+='status=yes,'; if(menu==false) windowProperties+='menubar=no,';
 else windowProperties+='menubar=yes,'; if(scroll==false) windowProperties+='scrollbars=no,';
 else windowProperties+='scrollbars=yes,'; if(resize==false) windowProperties+='resizable=no,';
 else windowProperties+='resizable=yes,'; if(w!="") windowProperties+='width='+w+',';
 if(h!="") windowProperties+='height='+h; if(windowProperties!="") { 
  if( windowProperties.charAt(windowProperties.length-1)==',') 
   windowProperties=windowProperties.substring(0,windowProperties.length-1); } 
 window.open(url,name,windowProperties);
}
// -->
</script>

<h1> Add Inventory Item </h1>

<form action="" method="post" id="formi">

<font size="2" color="#0000FF" onclick="RUNwc()">
<a href="javascript:;;">ISBN-13</a></font>
<input type="text" value="<?php echo $_GET['isbn']?>" name="isbn" size="20" />
<br>
<br>
<table border="1"><tr><td>
Acquired From: &nbsp &nbsp &nbsp &nbsp &nbsp 
<?php
printDropDown("From", $ENV_DB, $ENV_HOST, "SELECT *, FirstName+' '+LastName AS [Name] FROM CONTACT", "ContactID", "Name");
?>
<br>
&nbsp &nbsp &nbsp &nbsp For: $ 
<input type="text" value="0.00" name="Cost"  />
</td></tr></table>


<br>
<br>
Title: 
<input type="text" value="<?php echo $_GET['title'];?>" name="title" size="100" />
<br>
<br>
Authors (on each line): 
<textarea rows="5" cols="32" name="auths" />
<?php echo $_GET['author']?>
</textarea>
<br>
<br>
Publisher: 
<input type="text" value="<?php echo $_GET['publisher']?>" name="pub" />

Publisher Location: 
<input type="text" value="<?php echo $_GET['city']?>" name="publoc" /> 


Year: 
<input type="text" value="<?php echo $_GET['year']?>" name="pubyear" />

<br>
<br># of Pages: 
<input type="number" name="pp" />

<br><br>
Binding: &nbsp &nbsp &nbsp &nbsp &nbsp 
<?php
printDropDown("BindingDesc", $ENV_DB, $ENV_HOST, "SELECT * FROM BINDINGS", "BindingID", "BindingDesc");
?>
<br>


<br><br>
Condition: &nbsp &nbsp &nbsp &nbsp &nbsp 
<?php
printDropDown("ConditionDesc", $ENV_DB, $ENV_HOST, "SELECT * FROM CONDITIONS", "ConditionID", "ConditionDesc");
?>
<br>
Condition Comments: 
<textarea rows="5" cols="80" name="condition" />
</textarea>

<br>
<br>Comments: 
<textarea rows="5" cols="80" name="comments" />
</textarea>


<br>
<br>Keywords: 
<textarea rows="5" cols="80" name="keywords" />
</textarea>

<br><br>
Listing Price: 
<input type="text" value="<?php echo $_GET['listingprice']?>" name="listingprice" />

<br><br>
Bin ID: 
<input type="text" value="<?php echo $_GET['binid']?>" name="binid" />
<br><br>

<input type="submit" value="Enter Into Inventory"/>

</form>

<?php
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





$acqParams = array(
		  $_POST['From'],	          $_POST['Cost']
);

$acqID = SingletonInsertSQL($ENV_DB, $ENV_HOST, "INSERT INTO Acquisition (SellerContactID, PurchasePrice) 
OUTPUT INSERTED.AcquisitionID
VALUES (?, ?)", $acqParams ,"AcquisitionID");




$sql1 = "INSERT INTO Specimens (ISBN, Title, Authors, Publisher, PubLoc, Pages, Condition, Comments, AcquireID, PubYear, ChooseBinding, ChooseCondition, Keywords, UserEntered, ListingPrice, BinID)
OUTPUT INSERTED.SpecimenID
          VALUES (?, ?, ?, ?, ?, ? ,? ,?,?,?,?,?,?,?, ?,?)";

$_POST['auths'] = str_replace("\r\n", ';', $_POST['auths']);
$_POST['keywords'] = str_replace("\r\n", ';', $_POST['keywords']);

$params1 = array( $_POST['isbn'],
	          $_POST['title'],
	          $_POST['auths'],
	          $_POST['pub'],
	          $_POST['publoc'],
	          $_POST['pp'],
	          $_POST['condition'],
	          $_POST['comments'],
                  $acqID,
                  $_POST['pubyear'],
                  $_POST['BindingDesc'],
                  $_POST['ConditionDesc'],
                  $_POST['keywords'],
                  $_SESSION['user'],
				  $_POST['listingprice'],
                  $_POST["binid"]
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
      print 	"<script>window.location='specimen.php?sid=".$row['SpecimenID']."'</script>";
}

include "rssUpdate.php";


}
?>


</body>
</html>