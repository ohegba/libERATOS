<h1> Title Search</h1>

<form action="" method="post">
<input type="text" name="Title" value = "<?php if ($_SERVER['REQUEST_METHOD'] != 'POST') print $_GET['Title'] ?>" />
<input type="submit" value="Search Title" />
</form>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
unset($_GET['Title']);
$_POST['Title'] = str_replace("-", "", $_POST['Title']);

print "<a href="."http://www.amazon.com/gp/search/ref=sr_adv_b/?search-alias=stripbooks&unfiltered=1&field-keywords=&field-title=".urlencode($_POST['Title'])."> Amazon Search </a>";

print "<br><br><a href="."http://www.alibris.com/booksearch?keyword=".urlencode($_POST['Title'])."&qsort=p > Alibris Search </a>";

print "<br><br><a href="."http://www.worldcat.org/search?&qt=advanced&dblist=638&q=title%3A".urlencode($_POST['Title'])."> WorldCat </a>";


print "<br><br><a href=\"AddItem.php\"> Go to Add Inventory </a>";


}

?>


<a href="index.html"> <strong> Back to libERATOS Home! </strong> </a>