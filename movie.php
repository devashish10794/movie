<!DOCTYPE html>
<html>
<body>

<?php
include "simple_html_dom.php";
$a="/title/tt0347304/?ref_=nm_knf_i1";
$url="http://www.imdb.com".$a."";
$html= file_get_contents($url);
$dom = new DOMDocument();
 @$dom->loadHTML($html);
$xPath = new DOMXPath($dom);
$elements = $xPath->query("//*[@id='img_primary']/div[1]/a/img");
foreach ($elements as $e) 
{
       
        echo $e->getAttribute('src'). "<br /></a>";
}
$elements = $xPath->query("//*[@id='overview-top']/div[2]");
foreach ($elements as $e) 
{
       
        echo $e->nodeValue. "<br /></a>";
}
$elements = $xPath->query("//*[@id='overview-top']/div[3]/div[3]");
foreach ($elements as $e) 
{
        
        echo $e->nodeValue. "<br /></a>";
}

$elements = $xPath->query("//*[@id='titleUserReviewsTeaser']/div/div[3]/a[2]");
foreach ($elements as $e) 
{
        
        $x="http://www.imdb.com".$e->getAttribute('href')."";
        $html= file_get_contents($x);
		$dom = new DOMDocument();
		@$dom->loadHTML($html);
		$xPath = new DOMXPath($dom);
		for($i=1;$i<5;$i++)
		{
			$elements = $xPath->query("//*[@id='tn15content']/div[$i]/h2");
			foreach ($elements as $e) 
			{
	       				echo $e->nodeValue. "<br /></a>";

			}
			$elements = $xPath->query("//*[@id='tn15content']/div[$i]/a[2]");
			foreach ($elements as $e) 
			{
   	    				echo $e->nodeValue. "<br /></a>";	

			}	
			$elements = $xPath->query("//*[@id='tn15content']/p[$i]");
			foreach ($elements as $e) 
			{
       					echo $e->nodeValue. "<br /></a>";

			}
		}
}
?>

</body>
</html>
