<html>

<?php
include "idDropDown.php";
include "singleton.php";
include "environs.php";
?>

<?php


$record = GetFirstSQLRow($ENV_DB, $ENV_HOST, "SELECT *, acq.PurchasePrice, acq.SellerContactID FROM Specimens
LEFT JOIN Acquisition acq on AcquisitionID = AcquireID
LEFT JOIN Contact seller on ContactID = SellerContactID
WHERE SpecimenID = ".$_GET['sid'], null);





?>



<h1> Edit Inventory Item </h1>

<form action="" method="post" id="formi">

<font size="2" color="#0000FF" onclick="RUNwc()">
<a href="javascript:;;">ISBN-13</a></font>
<input type="text" value="<?php echo $record['ISBN']?>" name="isbn" size="20" />
<br>
<br>
<table border="1"><tr><td>
Acquired From: &nbsp &nbsp &nbsp &nbsp &nbsp 
<?php
printDropDownDefToKnown("From", $ENV_DB, $ENV_HOST, "SELECT *, FirstName+' '+LastName AS [Name] FROM CONTACT", "ContactID", "Name", $record['SellerContactID'] );
?>
<br>
&nbsp &nbsp &nbsp &nbsp For: $ 
<input type="text" value="<?php echo $record['PurchasePrice']?>" name="Cost"  />
</td></tr></table>

Listing Price: 
<input type="text" value="<?php echo $record['ListingPrice']?>" name="listingprice" />

Bin ID: 
<input type="text" value="<?php echo $record['BinID']?>" name="binid" />

<br>
<br>
Title: 
<input type="text" value="<?php echo $record['Title'];?>" name="title" size="100" />
<br>
<br>
Authors (on each line): 
<textarea rows="5" cols="32" name="auths" />
<?php echo $record['Authors']?>
</textarea>
<br>
<br>
Publisher: 
<input type="text" value="<?php echo $record['Publisher']?>" name="pub" />

Publisher Location: 
<input type="text" value="<?php echo $record['PubLoc']?>" name="publoc" /> 


Year: 
<input type="text" value="<?php echo $record['PubYear']?>" name="pubyear" />

<br>
<br># of Pages: 
<input type="number" value="<?php echo $record['Pages']?>" name="pp" />

<br><br>
Binding: &nbsp &nbsp &nbsp &nbsp &nbsp 
<?php
printDropDownDefToKnown("BindingDesc", $ENV_DB, $ENV_HOST, "SELECT * FROM BINDINGS", "BindingID", "BindingDesc", $record['ChooseBinding']);
?>
<br>


<br><br>
Condition: &nbsp &nbsp &nbsp &nbsp &nbsp 
<?php
printDropDownDefToKnown("ConditionDesc", $ENV_DB, $ENV_HOST, "SELECT * FROM CONDITIONS", "ConditionID", "ConditionDesc", $record['ChooseCondition']);
?>
<br>
Condition Comments: 
<textarea rows="5" cols="80" name="condition"/>
<?php echo $record['Condition']?>
</textarea>

<br>
<br>Comments: 
<textarea rows="5" cols="80" name="comments" />
<?php echo $record['Comments']?>
</textarea>


<br>
<br>Keywords: 
<textarea rows="5" cols="80" name="keywords" />
<?php echo $record['Keywords']?>
</textarea>

<br><br>
<input type="submit" value="Modify Specimen"/>

</form>




</html>


<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

$serverName = $ENV_HOST;
$connectionInfo = array( "Database"=>$ENV_DB);
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Could not connect.\n";
     die( print_r( sqlsrv_errors(), true));
}


$sql1 = "UPDATE Specimens 
SET ISBN = ?,
    Title = ?,
    Authors = ?,
    Publisher = ?,
    PubLoc = ?,
    Pages = ?,
    Condition = ?,
    Comments = ?,
    PubYear = ?,
    ChooseBinding = ?,
    ChooseCondition = ?,
    Keywords = ?,
    ListingPrice = ?,
    BinID = ?
    WHERE SpecimenID=".$record['SpecimenID'];

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
                  $_POST['pubyear'],
                  $_POST['BindingDesc'],
                  $_POST['ConditionDesc'],
                  $_POST['keywords'],
                  $_POST['listingprice'],
                  $_POST['binid']
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


  print 	"<script>window.location='specimen.php?sid=".$record['SpecimenID']."'</script>";


}


?>