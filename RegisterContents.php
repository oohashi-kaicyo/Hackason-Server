<?php

$display_major = 1;
$display_minor = 2;
$from_device_token = '****';
$content_text = '****';
$dsn      = 'mysql:dbname=****;host=localhost;charset=utf8';
$username = '****';
$password = '****';
$driver_options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
);

$idx = count($_FILES) - 1;

$tmp_path = $_FILES['upload_file'.$idx]['tmp_name'];
$target_path = 'upload/';
$target_path = $target_path.basename($_FILES['upload_file'.$idx]['name'] . '.jpg');

if(move_uploaded_file($tmp_path, $target_path)) {
    echo json_encode(array(
        'status' => 0
    ));
    pushToDisplay('****', 'http://****', '****');
}
echo json_encode(array(
        'status' => -1
));

try {
    $pdo = new PDO($dsn, $username, $password, $driver_options);
} catch (Exception $e) {
    echo $error = $e -> getMessage();
}
$sql = 'insert into Contents(display_major,
                             display_minor,
                             from_device_token,
                             content_text,
                             target_path
                              ) VALUES (
                             :display_major,
                             :display_minor,
                             :from_device_token,
                             :content_text,
                             :target_path
                            )';

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':display_major',      $display_major,     PDO::PARAM_INT);
$stmt->bindValue(':display_minor',      $display_minor,     PDO::PARAM_INT);
$stmt->bindParam(':from_device_token',  $from_device_token, PDO::PARAM_STR);
$stmt->bindParam(':content_text',       $content_text,      PDO::PARAM_STR);
$stmt->bindParam(':content_image_pass', $target_path ,      PDO::PARAM_STR);

$flag = $stmt->execute();

if ($flag) {
    print('データの追加に成功しました<br>');
} else {
    print('データの追加に失敗しました<br>');
}
$pdo = null;
?>

{
    "status"  : "0",
    "data"    : {
        "MAJOR"             : "<?=$display_major?>",
        "MINOR"             : "<?=$display_minor?>",
        "DEVICE_TOKEN"      : "<?=$from_device_token?>",
        "CONTENT_TEXT"      : "<?=$content_text?>",
        "CONTENT_IMAGE_PASS": "<?=$target_path?>"
    },
    "meta_data": {
        "name"      : "prez",
        "published" : "end.----------------------------"
    }
}
