<?php
$str = $_POST['blob'];
$len = strlen($str);
header("Content-type: text/text"); 
header("Content-Length: $len");
header('Content-Disposition: attachment; filename="banned.cfg"'); 
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("Content-Description: File Transfer");
header("Content-Transfer-Encoding: ascii"); 
echo $str;
?>
