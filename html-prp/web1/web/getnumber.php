<?php
header('content-type:application/json;charset=utf8');

$mySQLi = new MySQLi("127.0.0.1", "root", "17f44lle", "vulnerability", "3306");
if($mySQLi -> connect_errno){
	die('连接错误' . $mySQLi -> connect_error);
}
$mySQLi -> set_charset('utf8');

$sql = "select count(*) from vulnerability";

$res = $mySQLi -> query($sql);

list($rownum) = $res -> fetch_row();
echo $rownum;

$res -> free();
$mySQLi -> close();

exit;
?>