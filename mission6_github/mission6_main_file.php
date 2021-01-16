<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者用</title>

</head>
<body>

<?php
    error_reporting(E_ALL & ~E_NOTICE); //Noticeを表示させない

    //DBに接続
    $dsn = 'mysql:dbname=***;host=***';
    $user = '***';
    $password = '***';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    $file_name = $_FILES["file"]["name"];
    $file_tmp = $_FILES['file']['tmp_name'];
    $image = uniqid(mt_rand(), true);//ファイル名をユニーク化
    $image .= '.' . substr(strrchr($file_name, '.'), 1);//アップロードされたファイルの拡張子を取得
    $send = $_POST["send"];
    $id2 = $_POST["id2"];

    if(isset($send) && !empty($file_name)){
        $sql = $pdo -> prepare("INSERT INTO m6_file (filename, id2) VALUES (:filename, :id2)");
        if(!empty($file_name)){
            $sql -> bindParam(':filename', $image, PDO::PARAM_STR);
            move_uploaded_file($file_tmp,'./images/'.$image);//imagesディレクトリにファイル保存
        }else{
            $sql -> bindParam(':filename', $noimage, PDO::PARAM_STR);
        }
        $sql -> bindParam(':id2', $id2, PDO::PARAM_INT);
        $sql -> execute();
    }
?>

<form action = "" method = "post" enctype = "multipart/form-data">
    <br><input type = "text" name = "id2">
    <br><input type = "file" name = "file" accept = "image/*"><br><br><hr>
    <button type = "submit" id = "send" name = "send" style = "width:80px;">送信</button><br><hr>
</form>

<?php
    $sql = 'SELECT * FROM m6_file';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['id2'].',';
        echo $row['filename'].'<br>';
        echo "<hr>";
    }
?>

    
</body>
</html>