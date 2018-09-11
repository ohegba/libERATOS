<h1> ISBN-13 Info </h1>

<h3> For ISBN-10s, try prepending the Bookland EAN Country Prefix (978) to the number. </h3>


<form action="" method="post">
<input type="text" name="ISBN" value = "<?php if ($_SERVER['REQUEST_METHOD'] != 'POST') print $_GET['isbn'] ?>" />
<input type="submit" value="Search ISBN" />
</form>

<?php



function svg()
{
   ob_start();
   header('Content-type: text/plain');
   header('Content-Disposition: attachment; filename="default-filename.txt"');
   print $output;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
unset($_GET['ISBN']);
$_POST['ISBN'] = str_replace("-", "", $_POST['ISBN']);

print "<a href="."http://www.amazon.com/gp/search/ref=sr_adv_b/?field-isbn=".$_POST['ISBN']."> Amazon Search </a>";

print "<br><br><a href="."http://www.alibris.com/booksearch?isbn=".$_POST['ISBN']."> Alibris Search </a>";

print "<br><br><a href="."http://www.biblio.com/search.php?&author=&title=&keywords=&publisher=&illustrator=&minprice=&maxprice=&mindate=&maxdate=&quantity=&stage=1&cond=&format=&country=&dist=5&zip=&days_back=0&order=priceasc&pageper=20&isbn=".$_POST['ISBN']."> Biblio Search </a>";

print "<br><br><a href="."http://www.google.com/search?num=10&tbo=p&tbm=bks&q=isbn:".$_POST['ISBN']."> Google Book Search </a>";

print "<br><br><a href="."http://www.worldcat.org/search?&qt=advanced&dblist=638&q=bn%3A".$_POST['ISBN']."> WorldCat </a>";


print "<br><br><a href="."runWC.php?isbn=".$_POST['ISBN']."> Add To Inventory</a>";




  // print "<h2> ISBN-13:".$_POST['ISBN']."</h2>";
   $output = shell_exec('svgISBN'." ".$_POST['ISBN']);
   
   print "<br>".$output."<br><br><br><br>";

   print "<a href=downSVG.php?d=".urlencode($output).">Download SVG</a>";

}

?>

<br><br>
<a href="index.html"> <strong> Back to libERATOS Home! </strong> </a>