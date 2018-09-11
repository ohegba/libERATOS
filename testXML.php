<?php

$data = getWCMetadataFromISBN("978-1555705183");

function getWCMetadataFromISBN($ISBN13)
{

$bigIron = "http://xisbn.worldcat.org/webservices/xid/isbn/".$ISBN13."?method=getMetadata&format=xml&fl=*";

$xml = simplexml_load_file($bigIron);

foreach($xml->children() as $child)
  {
  
  	foreach($child->attributes() as $a => $b)
	{
	  $meta[$a] = $b;
	}
  
  }


return $meta;

}

print $data['publisher'];



?> 