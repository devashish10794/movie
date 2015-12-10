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
      <a class="navbar-brand" href="http://localhost/movies/index.php">MSE</a>
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
	$i=1;
	foreach ($elements as $e) 
	{
	   	 if($e->nodeValue!=NULL)
		{
        	$x=$e->getAttribute('href');
        	$y=$e->nodeValue;
       		$sql = "INSERT INTO movie (actor,actor_id) VALUES ('$y','$x')";
			mysqli_query($conn, $sql);
      	    echo "<a href='actor.php?search=".$x."'>".$i.") ".$y. "<br /></a>";
			$i++;
        }
	}
}

mysqli_close($conn);
?>
</div>
</body>
</html>









