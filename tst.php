<?php

$display_major = 1;//$_POST['major'];
$display_minor = 2;//$_POST['minor'];
$from_device_token = 'adkqwoke2341oka129312312';//$_POST['from_device_token'];
$content_text = 'hogehogehogehogheohoge';//$_POST['content_text'];
//$content_image_pass = 'local/local.hoge/hogehogehoge';//$_POST['content_image_pass'];
$dsn = 'mysql:dbname=Hackason;host=localhost;charset=utf8';
$username = 'root';
$password = 'root';
$driver_options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
);
// 画像形式のコンテンツを保存
$idx = count($_FILES) - 1;
$tmp_path = $_FILES['upload_file'.$idx]['tmp_name'];
$target_path = 'upload/';//保存ディレクトリ
$target_path = $target_path.basename($_FILES['upload_file'.$idx]['name'] . '.jpg');
// 一時保存画像を保存ディレクトリへ移動
if (move_uploaded_file($tmp_path, $target_path)) {
    echo json_encode(array(
        'status' => 0
    ));
    return;// ?
}
// ここでは，失敗の場合statusにマイナス値を返却
    echo json_encode(array(
        'status' => -1// ?
    ));
// データベースに接続
try {
    $pdo = new PDO($dsn, $username, $password, $driver_options);
    echo ('接続に成功');// 後でコメントアウト
} catch (Exception $e) {
    echo ('接続に失敗');// 後でコメントアウト
    echo $error = $e -> getMessage();
}
// Query
echo "Query<br>";
$sql = 'insert into Contents(display_major,
                             display_minor,
                             from_device_token,
                             content_text,
                             content_image_pass
                              ) VALUES (
                             :display_major,
                             :display_minor,
                             :from_device_token,
                             :content_text,
                             :content_image_pass
                            )';
echo "stml<br>";
try {
    $stmt = $pdo->prepare($sql);
    echo 'Success';
} catch (Exception $e) {
    echo $e -> getMessage();
    echo 'false';
}
echo "stml_prepare";
$stmt->bindValue(':display_major', $display_major, PDO::PARAM_INT);
$stmt->bindValue(':display_minor', $display_minor, PDO::PARAM_INT);
$stmt->bindParam(':from_device_token', $from_device_token, PDO::PARAM_STR);
$stmt->bindParam(':content_text', $content_text, PDO::PARAM_STR);
$stmt->bindParam(':content_image_pass', $target_path , PDO::PARAM_STR);
// 実行とflagに代入. flagを用意する必要なし
echo "stml_bind<br>";
$flag = $stmt->execute();
echo "stml_execute";
if($flag) {
    echo 'データの追加に成功しました<br>';// 後でコメントアウト
} else {
    echo 'データの追加に失敗しました<br>';// 後でコメントアウト
}
// DBへの接続を切断
$pdo = null;
?>
{
    "status": "0",
    "data": {
        "major": "<?=$display_major?>",
        "minor": "<?=$display_minor?>",
        "device_token": "<?=$from_device_token?>",
        "content_text": "<?=$content_text?>",
        "content_image_pass": "<?=$target_path?>"
    },
    "meta_data": {
        "name": "prez",
        "published": "end.----------------------------"
    }
}
