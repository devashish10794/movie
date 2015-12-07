<!DOCTYPE html>
<html>
<body>

<?php
include "simple_html_dom.php";
//include "crawling.php";
$a="/name/nm0451321/?ref_=fn_nm_nm_1";
$url="http://www.imdb.com".$a."";
$html= file_get_contents($url);
$dom = new DOMDocument();
 @$dom->loadHTML($html);
$xPath = new DOMXPath($dom);
////*[@id="knownfor"] //*[@id="knownfor"]/div[1]/a[2]
$elements = $xPath->query("//*[@id='knownfor']/div/a");
foreach ($elements as $e) 
{
    if($e->nodeValue!=NULL)
	{
        echo "<a href='movie.php?search=".$e->getAttribute('href')."'>".$e->nodeValue. "<br /></a>";
    }
}

?>

</body>
</html>
