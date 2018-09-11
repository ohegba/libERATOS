

<?php


function getWCMetadataFromISBN($ISBN13)
{

$bigIron = "http://xisbn.worldcat.org/webservices/xid/isbn/".$ISBN13."?method=getMetadata&format=xml&fl=*";

$xml = simplexml_load_file($bigIron);

foreach($xml->children() as $child)
  {
  	foreach($child->attributes() as $a => $b)
	{
print $b;
	    $meta[$a] = urlencode(ucwords($b));
	} 
  }


return $meta;

}

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{

print "RUNPHP";

$data = getWCMetadataFromISBN($_GET['isbn']);

$urlo = "AddItem.php?title=".$data['title']
."&author=".$data['author']
."&city=".$data['city']
."&publisher=".$data['publisher']
."&isbn=".$_GET['isbn']
."&year=".$data['year']
;
header("Location: ".$urlo);

}



?>