<!DOCTYPE html>
<html>
<body>

<?php
include "simple_html_dom.php";
//include "crawling.php";
$a= $_GET('search');
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
        echo $e->nodeValue. "<br />";
   		echo $e->getAttribute('href')."<br />";
    }
}

?>

</body>
</html>









