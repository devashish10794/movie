<?php
echo "<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta name='description' content=''>
    <meta name='author' content=''>

    <title>Movies</title>

    <!-- Bootstrap Core CSS -->
    <link href='css/bootstrap.min.css' rel='stylesheet'>

    <!-- Custom CSS -->
    <link href='css/stylish-portfolio.css' rel='stylesheet'>

    <!-- Custom Fonts -->
    <link href='font-awesome/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic' rel='stylesheet' type='text/css'>
</head>
<body>";


include "simple_html_dom.php";
$a=$_GET['search'];
$url="http://www.imdb.com".$a."";
$html= file_get_contents($url);
$dom = new DOMDocument();
 @$dom->loadHTML($html);
$xPath = new DOMXPath($dom);
echo "
<div class='container'>
  <table class='table'>
    <thead>
      <tr>
        <th>Movie display pic</th>
        <th>Name</th>
        <th>Rating</th>
        <th>Top Reviews</th>
        
      </tr>
    </thead>
    <tbody>
      <tr class='success'>
        <td>";
      
        $elements = $xPath->query("//*[@id='img_primary']/div[1]/a/img");
		foreach ($elements as $e) 
		{		
			echo "<img src=".$e->getAttribute('src')." style='width:150px; height:150px;'></img> <br />";
					
		}
		echo "
		</td>
       
		
        <td>";
 
        $elements = $xPath->query("//*[@id='overview-top']/div[2]");
		foreach ($elements as $e) 
		{
			echo $e->nodeValue. "<br />";
		}
		echo "
		</td>
       
        <td>";
        $elements = $xPath->query("//*[@id='overview-top']/div[3]/div[3]");
		foreach ($elements as $e) 
		{
			echo $e->nodeValue. "<br />";
		}
		echo "
        </td>
        <td>";
        $elements = $xPath->query("//*[@id='titleUserReviewsTeaser']/div/div[3]/a[2]");
		foreach ($elements as $e) 
		{
        $x="http://www.imdb.com".$e->getAttribute('href')."";
        $html= file_get_contents($x);
		$dom = new DOMDocument();
		@$dom->loadHTML($html);
		$xPath = new DOMXPath($dom);
		for($i=1;$i<4;$i++)
		{
			echo $i.")";
			$elements = $xPath->query("//*[@id='tn15content']/div[$i]/h2");
			foreach ($elements as $e) 
			{
	       			 echo $e->nodeValue. "<br />";
				
			}
			$elements = $xPath->query("//*[@id='tn15content']/div[$i]/a[2]");
			foreach ($elements as $e) 
			{
   	    				echo $e->nodeValue. "<br />";	

			}	
			$elements = $xPath->query("//*[@id='tn15content']/p[$i]");
			foreach ($elements as $e) 
			{
       					echo $e->nodeValue. "<br />";
       		}
       		echo "<br />";
		}
		}
		echo"
		</td>
		</div>
      </tr>
      </div>
    </tbody>
  </table>
</div>

</body>
</html>";
?>
