<?php
    /* 
     * ʹ��qrcode������ɶ�ά��
     * img��ǩsrcֵΪ��ҳ�����ַ�����Ҹ���get���� urlΪҪת��Ϊ��ά�����ַ
     */
    include 'phpqrcode.php';
    if ($_GET["url"] != "") {
        QRcode::png($_GET["url"], false, QR_ECLEVEL_L, 3, 2);
    }
?>