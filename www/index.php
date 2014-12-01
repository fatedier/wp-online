<?php
    include 'HttpClient.class.php';
    
    $web_url = $_POST["web_url"];
    $charset = "utf-8";
    $pageContents = "";
    
    /* 如果前7个字符不是 "http://"，则补上 */
    if (substr($web_url, 0, 7) != "http://" && substr($web_url, 0, 5) != "https" && $web_url != "")
    {
        $web_url = "http://".$web_url;
    }
    
    if ($web_url != "")
    {
        $pageContents = HttpClient::quickGet($web_url);
        
        /* 查找对应文本编码，替换当前页面的charset设置 */
        $check_pos = stripos($pageContents, "gb2312", 0);
        
        if ($check_pos != false)
        {
            $page_temp = substr($pageContents, $check_pos - 20, $check_pos);
            $check_charset = stripos($pageContents, "charset", 0);
            if ($check_charset != false)
            {
                $charset = "gb2312";
            }
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