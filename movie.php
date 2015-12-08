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
<body><h2>Movie Table</h2><br />";


include "simple_html_dom.php";
include "db_con.php";
$a=$_GET['search'];
$sql = "select img,name,rate,rev1,rev2,rev3 FROM movie_list WHERE id='$a'";

if (mysql_query($sql))
{
   
   $result=mysqli_query($conn, $sql);
   while ($row = mysql_fetch_array($result, MYSQL_NUM)) 
   {
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
      
        echo "<img src=".$row["img"]." style='width:150px; height:150px;'></img> <br />";
		echo "
		</td>
       
		
        <td>";
 
    
			echo $row["name"]. "<br />";
		
		echo "</td>
       
        <td>";
        echo $row["rate"]. "<br />";
		echo "
        </td>
        <td>";
        echo "1)".$row["rev1"]. "<br />2)".$row["rev2"]. "<br />3)".$row["rev3"];

		echo"
		</td>
		</div>
      </tr>
      </div>
    </tbody>
  </table>
</div>";
} 
}


else
{

$url="http://www.imdb.com".$a."";
$html= file_get_contents($url);
$dom = new DOMDocument();
 @$dom->loadHTML($html);
$xPath = new DOMXPath($dom);
$img='0';
$name='0';
$rate='0';
$rev1='0';
$rev2='0';
$rev3='0';
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
			$img=$e->getAttribute('src');
			echo "<img src=".$e->getAttribute('src')." style='width:150px; height:150px;'></img> <br />";
					
		}
		echo "
		</td>
       
		
        <td>";
 
        $elements = $xPath->query("//*[@id='overview-top']/div[2]");
		foreach ($elements as $e) 
		{
			$name=$e->nodeValue;
			echo $e->nodeValue. "<br />";
		}
		echo "
		</td>
       
        <td>";
        $elements = $xPath->query("//*[@id='overview-top']/div[3]/div[3]");
		foreach ($elements as $e) 
		{
			$rate=$e->nodeValue;
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
	       			 $rev1=$e->nodeValue;
	       			 echo $e->nodeValue. "<br />";
				
			}
			$elements = $xPath->query("//*[@id='tn15content']/div[$i]/a[2]");
			foreach ($elements as $e) 
			{
   	    				$rev2=$e->nodeValue;
   	    				echo $e->nodeValue. "<br />";	

			}	
			$elements = $xPath->query("//*[@id='tn15content']/p[$i]");
			foreach ($elements as $e) 
			{
       					$rev3=$e->nodeValue;
       					echo $e->nodeValue. "<br />";
       		}
       		echo "<br />";
		}
		}
		//$sql = "UPDATE movie_list SET img = '$img' , img = '$img' , name = '$name', rate = '$rate', rev1 = '$rev1', rev2 = '$rev2', rev3 = '$rev3' WHERE id = '$a'";
			
			$sql = "INSERT INTO movie_list (id,img,name,rate,rev1,rev2,rev3) VALUES ('$a','$img','$name','$rate','$rev1','$rev2','$rev3')";
			mysqli_query($conn, $sql);
		echo"
		</td>
		</div>
      </tr>
      </div>
    </tbody>
  </table>
</div>";

}
echo"
</body>
</html>";

mysqli_close($conn);
?>
