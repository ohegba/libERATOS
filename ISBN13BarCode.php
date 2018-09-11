<h1> ISBN-13 Search </h1>

<form action="" method="post">
<input type="text" name="ISBN" />
<input type="submit" value="Gen Bar Code" />
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
   print "<h2>".$_POST['ISBN']."</h2>";
   $output = shell_exec('svgISBN'." ".$_POST['ISBN']);
   print $output;
}
?>