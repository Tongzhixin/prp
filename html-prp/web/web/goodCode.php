<?php
header('content-type:application/json;charset=utf8');
$data = array();
class Result {
	public $id;
	public $name;
}

$mySQLi = new MySQLi("127.0.0.1", "root", "17f44lle", "vulnerability", "3306");
if($mySQLi -> connect_errno){
	die('连接错误' . $mySQLi -> connect_error);
}
$mySQLi -> set_charset('utf8');

$sql = "select count(*) from goodCode";
$res = $mySQLi -> query($sql);
list($total) = $res -> fetch_row();

$start = (string)($total-$_GET['start']-$_GET['num']);
$number = (string)$_GET['num'];
$sql = "select id, func_name from goodCode LIMIT ".$start." , ".$number;

$res = $mySQLi -> query($sql);

while ($row = $res -> fetch_array()){
	$result = new Result();
	$result->id = $row[0];
	$result->name = $row[1];
	$data[] = $result;
}
$json = json_encode($data);
echo $json;

$res -> free();
$mySQLi -> close();

exit;
?>