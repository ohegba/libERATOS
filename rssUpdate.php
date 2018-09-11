<?php

include "environs.php";

$timestamp = time();
$xml .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?> <rss version=\"2.0\">";
$xml .= "<channel>";
$xml .= "  <title>Books Add'd To libERATOS</title> ";
$xml .= "        <description>The books as they are added to the inventory</description>";
$xml .= "        <link>http://".$_SERVER['SERVER_NAME']."/libERATOS</link>";
$xml .= "        <lastBuildDate>".date('D, d M Y g:i:s O', $timestamp)."</lastBuildDate>";
$xml .= "        <pubDate>".date('D, d M Y g:i:s O', $timestamp)."</pubDate>";
$xml .= "        <ttl>1800</ttl>";



$serverName = $ENV_HOST;
$connectionInfo = array( "Database"=>$ENV_DB);
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn === false )
{
     echo "Could not connect.\n";
     die( print_r( sqlsrv_errors(), true));
}

$sql1 = "SELECT TOP 13 * FROM Specimens
ORDER BY SpecimenID DESC";

$stmt1 = sqlsrv_query( $conn, $sql1 );

while( $row = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC))
{

      $xml .= "\r\n\r\n<item>\r\n<title>".htmlspecialchars($row['Title'])."</title>";
      $xml .= "\r\n<description>".htmlspecialchars($row['Authors'])."</description>";
      $xml .= "\r\n<link>http://".$_SERVER['SERVER_NAME']."/libERATOS/specimen.php?sid=".htmlspecialchars($row['SpecimenID'])."</link>";
      $xml .= "\r\n<guid>".htmlspecialchars($row['SpecimenID'])."</guid>";
      $xml .= "\r\n<pubDate>".date('D, d M Y g:i:s O', $timestamp)."</pubDate>\r\n</item>";
      
}

$xml .="</channel></rss>";

file_put_contents("feed.xml", $xml);

?>