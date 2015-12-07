<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Movies</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/stylish-portfolio.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
</head>
<body>

<?php
include "simple_html_dom.php";
$a=$_GET['search'];
$a = preg_replace('/\s+/', '+', $a);
echo "<h2>" . $a . "</h2>";
$url="http://www.imdb.com/find?ref_=nv_sr_fn&q=".$a."&s=nm";
$html= file_get_contents($url);
$dom = new DOMDocument();
 @$dom->loadHTML($html);
$xPath = new DOMXPath($dom);
$elements = $xPath->query("//td/a");
foreach ($elements as $e) 
{
    if($e->nodeValue!=NULL)
	{
        echo "<a href='actor.php?search=".$e->getAttribute('href')."'>".$e->nodeValue. "<br /></a>";
   		
    }
}

?>

</body>
</html>









