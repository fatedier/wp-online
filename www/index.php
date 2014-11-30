<?php
    include 'HttpClient.class.php';
    
    $web_url = $_POST["web_url"];
    $charset = "utf-8";
    $pageContents = "";
    
    /* 如果前7个字符不是 "http://"，则补上 */
    if (substr($web_url, 0, 7) != "http://" && $web_url != "")
    {
        $web_url = "http://".$web_url;
    }
    
    if ($web_url != "")
    {
        $pageContents = HttpClient::quickGet($web_url);
        /* 去除所有空格，查找对应文本编码，如果是gb2312就转换为utf-8*/
        $content_temp = ereg_replace(" ", "", $pageContents);
        $check1 = stripos($content_temp, "charset=\"gb2312\"", 0);
        $check2 = stripos($content_temp, "charset=gb2312", 0);
        
        if (($check1 != false) || ($check2 != false))
        {
            $charset = "gb2312";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
<title>php test</title>
<?php
    /* 按照原网页的编码修改当前网页编码 */
    echo '<meta http-equiv="Content-Type" content="text/html; charset='.$charset.'"/>';
?>
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
    if ($web_url != "")
    {
		echo("<div style=\"background-color:white;font-size:18px\" align=\"center\">");
        echo $web_url."<br/><br/>";
		echo("</div>");
        
        echo "<div>".$pageContents."</div>";
    }
?>

</body>
</html>