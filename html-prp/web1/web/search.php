<?php
header('content-type:application/json;charset=utf8');
$data = array();
class Result {
	public $id;
	public $name;
	public $danger;
	public $language;
	public $time;
}

$mySQLi = new MySQLi("127.0.0.1", "root", "17f44lle", "vulnerability", "3306");
if($mySQLi -> connect_errno){
	die('连接错误' . $mySQLi -> connect_error);
}
$mySQLi -> set_charset('utf8');

$cwe = (string)$_GET['cwe_id'];
$sql = "select count(*) from cwe where cwe_id = '".$cwe."';";
$res = $mySQLi -> query($sql);
list($total) = $res -> fetch_row();

$start = (string)($total-$_GET['start']-$_GET['num']);
$number = (string)$_GET['num'];
$sql = "select vulnerability_id from cwe where cwe_id = '".$cwe."' LIMIT ".$start." , ".$number;

$res = $mySQLi -> query($sql);

while ($row = $res -> fetch_array()){
	$result = new Result();
	$result->id = $row[0];
	$sql = "select vulnerability_name, danger, language, change_time from vulnerability where vulnerability_id = '".$result->id."';";
	$re = $mySQLi -> query($sql);
	while ($ro = $re -> fetch_array()) {
		$result->name = $ro[0];
		$result->danger = $ro[1];
		$result->language = $ro[2];
		$result->time = $ro[3];
	}
	$data[] = $result;
}
$json = json_encode($data);
echo $json;


$res -> free();
$mySQLi -> close();

exit;
?>