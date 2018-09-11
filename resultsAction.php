<?php

if ($_POST['batchUIEE'] != null)
{

include "uiee.php";

UIEEHeader();

foreach ($_POST['recCheck'] as &$value)
{
    print "".UIEE($value)."";
}


}


if ($_POST['batchbib'] != null)
{

include "bibtex_exp.php";

if (!empty($_POST))
foreach ($_POST['recCheck'] as &$value)
{
    print "".bibtexdump($value)."";
}


}




?>