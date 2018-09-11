<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head><meta content="text/html; charset=ISO-8859-1" http-equiv="content-type"><title>libERATOS</title></head><body style="color: rgb(0, 102, 0); background-color: rgb(255, 255, 255); background-image: url(bgimg.png);" alink="#000099" link="#000099" vlink="#990099">
<div style="text-align: center;"><br>
<br>
<br>
<?php

$usrName = $_SESSION['user'];
print "hi";
if ($usrName != null)
{
   print "<h4> Hello, ".$_SESSION['user']."!</h4>";   
}
?>
<br>
<br>
<div style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<br>
</div>
<img style="width: 483px; height: 118px;" alt="libERATOS" src="logo.png">

<h6> Enter the name of the author, book, or a full or partial ISBN to get started. </h6>

<form action="searchSpecimens.php" method="post">
<input size="100" name="searchText">
<br>
<input type="Submit" value="Search Inventory">

</form>

<br>

<a href="AddItem.php"><strong>Add Inventory</strong></a>
<a href="AddContact.php"><strong>Add Contact</strong></a>
<a href="ISBN.php"><strong>ISBN Lookup</strong></a>


<br>



</div>
</body></html>