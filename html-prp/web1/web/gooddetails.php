<?php
header('content-type:application/json;charset=utf8');
$data = array();
class Result {
	public $name;
	public $code;
}

$mySQLi = new MySQLi("127.0.0.1", "root", "17f44lle", "vulnerability", "3306");
if($mySQLi -> connect_errno){
	die('连接错误' . $mySQLi -> connect_error);
}
$mySQLi -> set_charset('utf8');

$func_name = $_GET['name'];

$sql = "select func_name, code from goodCode where func_name = '".$func_name."';";

$res = $mySQLi -> query($sql);

while ($row = $res -> fetch_array()){
	$result = new Result();
	$result->name = $row[0];
	$result->code = $row[1];
	$data[] = $result;
}
$json = json_encode($data);
echo($json);

$res -> free();
$mySQLi -> close();
?>