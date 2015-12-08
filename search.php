<!DOCTYPE html>
<html>

<head>
<title>Movies</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/stylish-portfolio.css" rel="stylesheet">
</head>
<body>

<?php
include "simple_html_dom.php";
include "db_con.php";
$a=$_GET['search'];
$a = preg_replace('/\s+/', '+', $a);
$b=$a;
$q = str_replace('+', ' ', $b);
echo "<h2>Top searches related to ".$q."</h2>";
$sql = "select actor_id FROM movie WHERE actor='$q' AND time>=date_sub(now(), 24 hours)";
if (mysql_query($sql))
{
   $result=mysqli_query($conn, $sql);
   $row = mysqli_fetch_row($result);
   header('Location: http://localhost/movies/actor.php?search='.$row[0].'');
} 
else 
{    
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
        	$x=$e->getAttribute('href');
        	$y=$e->nodeValue;
       		$sql = "INSERT INTO movie (actor,actor_id) VALUES ('$y','$x')";
			mysqli_query($conn, $sql);
      	    echo "<a href='actor.php?search=".$x."'>".$y. "<br /></a>";
        }
	}
}

mysqli_close($conn);
?>

</body>
</html>









