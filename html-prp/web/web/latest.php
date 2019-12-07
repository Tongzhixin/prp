<?php
header('content-type:application/json;charset=utf8');
$data = array();
class Result {
	public $name;
	public $danger;
	public $language;
}

$mySQLi = new MySQLi("127.0.0.1", "root", "17f44lle", "vulnerability", "3306");
if($mySQLi -> connect_errno){
	die('连接错误' . $mySQLi -> connect_error);
}
$mySQLi -> set_charset('utf8');

$getNum = "select count(*) from vulnerability";
$num = $mySQLi -> query($getNum);
list($rownum) = $num -> fetch_row();
$start = $rownum -10;
$sql = "select vulnerability_name, danger, language from vulnerability LIMIT ".$start." , 10";

$res = $mySQLi -> query($sql);

while ($row = $res -> fetch_array()){
	$result = new Result();
	$result->name = $row[0];
	$result->danger = $row[1];
	$result->language = $row[2];
	$data[] = $result;
}
$json = json_encode($data);
echo $json;

$res -> free();
$mySQLi -> close();

exit;
?>