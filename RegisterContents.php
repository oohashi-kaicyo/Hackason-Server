<?php
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
