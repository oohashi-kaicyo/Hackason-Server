<?php

$display_device_token = $_POST['display_device_token'];
$dsn = "mysql:dbname=Hackason;host=localhost;charset=utf8";
$usr_name = "root";
$password = "root";
try {
	$dbh = new PDO($dsn,$usr_name,$password);
} catch (PDOException $e) {
	var_dump($e->getMessage());
	exit;	
}
// データをDBに挿入
function data_insert($device_token)
{
	global $dbh;
	$major = major_assign();
	$stmt = $dbh->prepare("insert into display_user (display_device_token,display_major) values 
	(:display_device_token,:display_major)");
	$stmt->bindParam(":display_device_token", $display_device_token);
	$stmt->bindParam(":display_major", $display_major);
	$display_device_token = $device_token;
	$display_major = $major;
	make_directory($major);
	$stmt->execute();
}
// major値を決める（初めてinsertするときは0,次から最新のmajor値+1)
function major_assign()
{
	global $dbh;
	$sth = $dbh->prepare("SELECT display_major FROM display_user ORDER BY display_major desc LIMIT 1");
	$sth->execute();
	$result = $sth->fetchAll();
	$major_count = $result[0][0];
	if ($major_count == NULL) {
		return 0;
	 } else {
		return $major_count + 1;
	}
}
// directorya作成
function make_directory ($major)
{
	$dir_name = "major${major}";
	mkdir("/var/www/html/Hackason/images/${dir_name}");
}
data_insert("kaen");
// data_insert($display_device_token);
echo "success!";
?>
