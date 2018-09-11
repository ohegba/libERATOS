<h1> Generate QR-Code </h1>

<form action="" method="post">
<input type="text" name="ISBN" />
<input type="submit" value="Generate QR Code" />
</form>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

   $output = shell_exec('genQR'." \"".$_POST['ISBN']."\"");
   
   
   
   print "<br>".$output."<br><br><br><br>";

}

?>
