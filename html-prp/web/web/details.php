<?php
header('content-type:application/json;charset=utf8');
$data = array();
class Result {
	public $id;
	public $name;
	public $release_time;
	public $change_time;
	public $language;
	public $confidentiality;
	public $integrity;
	public $availability;
	public $privileges_required;
	public $authentication;
	public $danger;
	public $vulnerability_type;
	public $threat_type;
	public $source;
	public $attack_vector;
	public $attack_complexity;
	public $access_vector;
	public $access_complexity;
	public $UI;
	public $description;
	public $code;
	public $POC;
	public $patch_code;
	public $announcement;
	public $patch;
	public $CWE_id;
}

$mySQLi = new MySQLi("127.0.0.1", "root", "17f44lle", "vulnerability", "3306");
if($mySQLi -> connect_errno){
	die('连接错误' . $mySQLi -> connect_error);
}
$mySQLi -> set_charset('utf8');

$vulnerability_name = $_GET['name'];
$vulnerability_id = $_GET['id'];

if ($vulnerability_name == '') {
	$sql = "select * from vulnerability where vulnerability_id = '".$vulnerability_id."';";
} else {
	$sql = "select * from vulnerability where vulnerability_name = '".$vulnerability_name."';";
}

$res = $mySQLi -> query($sql);

while ($row = $res -> fetch_array()){
	$result = new Result();
	$result->id = $row[0];
	$result->name = $row[1];
	$result->release_time = $row[2];
	$result->change_time = $row[3];
	$result->language = $row[4];
	$result->confidentiality = $row[5];
	$result->integrity = $row[6];
	$result->availability = $row[7];
	$result->privileges_required = $row[8];
	$result->authentication = $row[9];
	$result->danger = $row[10];
	$result->vulnerability_type = $row[11];
	$result->threat_type = $row[12];
	$result->source = $row[13];
	$result->attack_vector = $row[14];
	$result->attack_complexity = $row[15];
	$result->access_vector = $row[16];
	$result->access_complexity = $row[17];
	$result->UI = $row[18];
	$result->description = $row[19];
	$result->code = $row[20];
	$result->POC = $row[21];
	$result->patch_code = $row[22];
	$result->announcement = $row[23];
	$result->patch = $row[24];
	$cwe = "";
	$sql = "select cwe_id from cwe where vulnerability_id = '".$result->id."';";
	$cwe_result = $mySQLi -> query($sql);
	while ($cwe_row = $cwe_result -> fetch_array()){
		if ($cwe != "") {
			$cwe = ",".$cwe;
		}
		$cwe = $cwe_row[0].$cwe;
	}
	if ($cwe == "") {
		$cwe = null;
	}
	$result->CWE_id = $cwe;
	$data[] = $result;
}
$json = json_encode($data);
echo($json);

$res -> free();
$mySQLi -> close();
?>