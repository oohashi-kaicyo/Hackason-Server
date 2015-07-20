<?php

$device_token =  '067ee4422fb01c002a1754ff0127d70b0663486916603d2eac8e3181cf32333b';
$url = 'http://133.2.37.224/Hackason/ApnsPHP-master/PushToDisplay.php';
$text =  'didUpperSwipeAnyone';
require_once 'PushToDisplay.php';
/*
//POSTデータ
$data = array(
    "device_token" => "067ee4422fb01c002a1754ff0127d70b0663486916603d2eac8e3181cf32333b",
    "url" => "http://133.2.37.224/Hackason/ApnsPHP-master/PushToDisplay.php",
    "text" => "didUpperSwipeAnyone"
);
$data = http_build_query($data, "", "&");

//header
$header = array(
    "Content-Type: application/x-www-form-urlencoded",
    "Content-Length: ".strlen($data)
);

$context = array(
    "http" => array(
        "method"  => "POST",
        "header"  => implode("\r\n", $header),
        "content" => $data
    )
);
*/
//$url = "http://localhost/test.php";
//echo file_get_contents($url, false, stream_context_create($context));
    
//PushToDisplay('067ee4422fb01c002a1754ff0127d70b0663486916603d2eac8e3181cf32333b', 'http://133.2.1.1', 'hello Swiped');
   $idx = count($_FILES) - 1;
    //今回は1つのみの画像Uploadだが
    //複数の場合はforで回して取得
    $tmp_path = $_FILES['upload_file'.$idx]['tmp_name'];
    $target_path = 'upload/';
    $target_path = $target_path.basename($_FILES['upload_file'.$idx]['name'] . '.jpg');
    //$target_path = $target_path.basename('minor1'. '.jpg');

    //一時保存画像を保存デジレクトリに移動
    if(move_uploaded_file($tmp_path, $target_path)){
        //保存成功
        echo json_encode(array(
            'status' => 0
        ));
	//pushToDisplay($device_token, $url, $text);
 pushToDisplay('067ee4422fb01c002a1754ff0127d70b0663486916603d2eac8e3181cf32333b', 'http://133.2.1.1', 'hello Swiped');
        //return;
    }
   //file_get_contents ( string $filename [, bool $use_include_path = false [, resource $context [, int $offset = -1 [, int $maxlen ]]]] );
   //pushToDisplay('067ee4422fb01c002a1754ff0127d70b0663486916603d2eac8e3181cf32333b','http://133.2.37.224/Hackason/upload/apple.jpg','didUpperSwipeAnyone');

   //-------------------------------------------------------------------------------------------------

//file_get_contents($url, false, stream_context_create($context));  
//ここでは、失敗の場合statusにマイナス値を返している
echo json_encode(array(
        'status' => -1
));
