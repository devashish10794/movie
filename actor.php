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
<h2>Top 3 Movies</h2>
<?php
include "simple_html_dom.php";
include "db_con.php";
$a=$_GET['search'];
$sql = "select mov1,mov1_link,mov2,mov2_link,mov3,mov3_link FROM movie WHERE actor_id='$a'";
$result = mysql_query($sql);
if ($result)
{
   while ($row = mysql_fetch_array($result, MYSQL_NUM)) 
   {
   		echo "<a href='movie.php?search=".$row["mov1_link"]."' target='_blank'>".$row["mov1"]. "<br /></a>";
   		echo "<a href='movie.php?search=".$row["mov2_link"]."' target='_blank'>".$row["mov2"]. "<br /></a>";
  	    echo "<a href='movie.php?search=".$row["mov3_link"]."' target='_blank'>".$row["mov3"]. "<br /></a>";
     
}
   
} 
else
{
$url="http://www.imdb.com".$a."";
$html= file_get_contents($url);
$dom = new DOMDocument();
 @$dom->loadHTML($html);
$xPath = new DOMXPath($dom);
$elements = $xPath->query("//*[@id='knownfor']/div/a");
$i=1;
foreach ($elements as $e) 
{
    if($e->nodeValue!=" " && $i<4)
	{
       
     
        $x=$e->getAttribute('href');
        $y=$e->nodeValue;
        if($i==1)
        {
       		$sql = "UPDATE movie SET mov1 = '$y' , mov1_link = '$x' WHERE actor_id = '$a'";
       	}
       	else if($i==2)
       	{
       		$sql = "UPDATE movie SET mov2 = '$y' , mov2_link = '$x' WHERE actor_id = '$a'";
       	}
       	else
       	{
       		$sql = "UPDATE movie SET mov3 = '$y' , mov3_link = '$x' WHERE actor_id = '$a'";
       	}

		mysqli_query($conn, $sql);
        echo "<a href='movie.php?search=".$e->getAttribute('href')."' target='_blank'>".$e->nodeValue. "<br /></a>";
        $i++;
    }
}
}
mysqli_close($conn);
?>

</body>
</html>
