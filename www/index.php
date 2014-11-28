<!DOCTYPE html>
<html>
<head>
<title>php test</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
</head>
<body>

<div style="background-color:white" align="center">
    <br/>
    <form action="index.php" method="post" width="100%">
    url:&nbsp; <input type="text" name="web_url" style="width:50%;height:25px"><br><br>
    <input type="submit" value="Get" style="width:80px;height:30px">
    </form>
    <br/>
</div>

<?php
    include 'HttpClient.class.php';
    
    $web_url = $_POST["web_url"];
    
    /* 如果前7个字符不是 "http://"，则补上 */
    if (substr($web_url, 0, 7) != "http://" && $web_url != "")
    {
        $web_url = "http://".$web_url;
    }
    
    if ($web_url != "")
    {
		echo("<div style=\"background-color:white;font-size:18px\" align=\"center\">");
        echo $web_url."<br/><br/>";
		echo("</div>");
		
        $pageContents = HttpClient::quickGet($web_url);
        echo "<div>".$pageContents."</div>";            
    }
?>

</body>
</html>
