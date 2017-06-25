<?php

$dsn = "mysql:host=localhost;port=****;dbname=****";
$usr_name = "****";
$password = "****";

try {
    $dbh = new PDO($dsn,$usr_name,$password);
} catch(PDOException $e){
    var_dump($e->getMessage());
    exit;	
}

function data_insert($device_token) {
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

function major_assign(){
    global $dbh;
    $sth = $dbh->prepare("SELECT display_major FROM display_user ORDER BY display_major desc LIMIT 1");
    $sth->execute();
    $result = $sth->fetchAll();
    $major_count = $result[0][0];
    if($major_count == NULL) {
        return 0;
    } else {
        return $major_count + 1;
    }
}

function make_directory ($major) {
    $dir_name = "major${major}";
    mkdir("/Applications/MAMP/htdocs/Hackason-Server/images/${dir_name}");
}

data_insert("natu");
data_insert("aki");

?>
