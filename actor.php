<!DOCTYPE html>
<html>

<head>

    

    <title>Movies</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/stylish-portfolio.css" rel="stylesheet">

   
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="http://localhost/movies/index.php">Brand</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <form class="navbar-form navbar-left" role="search" action="http://localhost/movies/search.php" method="get">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search" name="search" id="search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
    
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="jumbotron">
<h2>Top Movies</h2> 
<?php
include "simple_html_dom.php";
include "db_con.php";
$a=$_GET['search'];
$sql = "select mov1,mov1_link,mov2,mov2_link,mov3,mov3_link FROM movie WHERE actor_id='$a' AND time<=date_sub(now(), 24 hours)";
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
//*[@id="knownfor"]/div[1]/a[2] //*[@id="knownfor"]/div[2]/a[2]
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
        echo "<a href='movie.php?search=".$e->getAttribute('href')."' target='_blank'>".$i.") ".$e->nodeValue. "<br /></a>";
        $i++;
    }
}
}
mysqli_close($conn);
?>
</div>
</body>
</html>
