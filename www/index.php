<?php
    include dirname(__file__).'/http/HttpClient.class.php';
    
    $web_url = $_POST["web_url"];
    $charset = "utf-8";
    $pageContents = "";
    
    /* 如果前7个字符不是 "http://"，则补上 */
    if (substr($web_url, 0, 7) != "http://" && substr($web_url, 0, 5) != "https" && $web_url != "") {
        $web_url = "http://".$web_url;
    }
    
    if ($web_url != "") {
        $pageContents = HttpClient::quickGet($web_url);
        
        /* 需要做转换的网页编码格式 */
        $charset_list = array("gb2312", "gbk");

        /* 查找是否存在指定编码 */
        foreach ($charset_list as $charset_one) {
            $charset_pos = stripos($pageContents, $charset_one, 0);
            if ($charset_pos != false) {
                /* 查找左括号的位置 */
                $bracket_pos = strripos(substr($pageContents, 0, $charset_pos), "<", 0);
                if ($bracket_pos != false) {
                    /* 查找字符编码所在标签是否是meta */
                    $meta_pos = stripos(substr($pageContents, $bracket_pos, $bracket_pos + 4), "meta");
                    if ($meta_pos != false) {
                        $charset = $charset_pos;
                        break;
                    }
                }
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
    if ($web_url != "") {
		echo("<div style=\"background-color:white;font-size:18px\" align=\"center\">");
        echo $web_url."<br/><br/>";
		echo("</div>\n");
        
        /* 生成网址二维码 */
		/* google api方式 */
		/*
        function generateQRfromGoogle($chl, $widhtHeight = '80', $EC_level = 'L', $margin = '0') 
        {
            echo '<img src="http://chart.apis.google.com/chart?chs='.$widhtHeight.'x'.$widhtHeight.'&cht=qr&chld='.$EC_level.'|'.$margin.'&chl='.$chl.'" alt="QR code" widhtHeight="'.$size.'" widhtHeight="'.$size.'"/>';
        }
        echo("<div style=\"background-color:white;font-size:18px\" align=\"center\">");
        generateQRfromGoogle($web_url);
        echo("</div>");
        */
        
        /* 二维码，img标签的src为生成二维码的php文件 */
        echo("<div style=\"background-color:white;\" align=\"center\">");
        echo("<img src=\"qrcode/get_qr_png.php?url=$web_url\" alt=\"qrpng\" /><br/><br/>");
        echo("</div>");
        
        echo "<div>".$pageContents."</div>";
    }
?>

</body>
</html>