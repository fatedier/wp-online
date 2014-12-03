<?php
    /* 
     * 使用qrcode类库生成二维码
     * img标签src值为本页面的网址，并且附加get参数 url为要转换为二维码的网址
     */
    include 'phpqrcode.php';
    if ($_GET["url"] != "") {
        QRcode::png($_GET["url"], false, QR_ECLEVEL_L, 3, 2);
    }
?>