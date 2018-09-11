<form action="" method="post">
<input type="text" name="ISBN" />
<input type="submit" value="Add Contact" />
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
   print "<h2> ISBN-13:".$_POST['ISBN']."</h2>";
   $output = shell_exec('svgISBN'." ".$_POST['ISBN']);
   print $output."<br>";
   print "<a href="."http://www.amazon.com/gp/search/ref=sr_adv_b/?field-isbn=".$_POST['ISBN']."> Amazon Search </a>";

}
?>