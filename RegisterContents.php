<?php

//コンテンツをうける処理
$display_major = 1;//$_POST['major'];
$display_minor = 2;//$_POST['minor'];
$from_device_token = 'adkqwoke2341oka129312312';//$_POST['from_device_token'];
$content_text = 'hogehogehogehogheohoge';//$_POST['content_text'];
//$content_image_pass = 'local/local.hoge/hogehogehoge';//$_POST['content_image_pass'];

//データベース情報
$dsn = 'mysql:dbname=Hackson;host=localhost;charset=utf8';
$username = 'root';
$password = 'root';
$driver_options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
);

    $idx = count($_FILES) - 1;
    //今回は1つのみの画像Uploadだが
    //複数の場合はforで回して取得
    $tmp_path = $_FILES['upload_file'.$idx]['tmp_name'];
    $target_path = 'upload/';//保存ディレクトリ
    $target_path = $target_path.basename($_FILES['upload_file'.$idx]['name'] . '.jpg');
    //→upload/thumbnail.jpg

    //一時保存画像を保存デジレクトリに移動
    if(move_uploaded_file($tmp_path, $target_path)){
        //保存成功
        echo json_encode(array(
            'status' => 0
        ));
        return;
    }
    //ここでは、失敗の場合statusにマイナス値を返している
    echo json_encode(array(
        'status' => -1
    ));


try {

//データベースに接続
    $pdo = new PDO($dsn, $username, $password, $driver_options);
	echo ('接続に成功しました。');

} catch (Exception $e) {
    echo $error = $e -> getMessage();
}

//SQL文を用意
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

//データベースとSQL文
$stmt = $pdo->prepare($sql);

//用意したSQL文に値を代入
$stmt->bindValue(':display_major', $display_major, PDO::PARAM_INT);
$stmt->bindValue(':display_minor', $display_minor, PDO::PARAM_INT);
$stmt->bindParam(':from_device_token', $from_device_token, PDO::PARAM_STR);
$stmt->bindParam(':content_text', $content_text, PDO::PARAM_STR);
$stmt->bindParam(':content_image_pass', $target_path , PDO::PARAM_STR);

//実行とflagに代入
$flag = $stmt->execute();

//flagに代入できたら成功
if ($flag){
    print('データの追加に成功しました<br>');
}else{
    print('データの追加に失敗しました<br>');
}

//接続を切ります
$pdo = null;
?>

<?
//JSON形式で出力
?>
{
    "status": "0",
    "data": {
        "MAJOR": "<?=$display_major?>",
        "MINOR": "<?=$display_minor?>",
        "DEVICE_TOKEN": "<?=$from_device_token?>",
        "CONTENT_TEXT": "<?=$content_text?>",
        "CONTENT_IMAGE_PASS": "<?=$target_path?>"
    },
    "meta_data": {
        "name": "prez",
        "published": "end.----------------------------"
    }
}
