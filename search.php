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
include "db_con.php";
$a=$_GET['search'];
$a = preg_replace('/\s+/', '+', $a);
$b=$a;
$q = str_replace('+', ' ', $b);
echo "<h2>Top searches related to ".$q."</h2>";
$sql = "select actor_id FROM movie WHERE actor='$q'";
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









