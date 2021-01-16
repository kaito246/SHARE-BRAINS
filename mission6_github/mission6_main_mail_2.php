<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>通報ページ｜SHARE BRAINS</title>
    
</head>
<body>

<?php

error_reporting(E_ALL & ~E_NOTICE); //Noticeを表示させない
session_start();

    $urltoken = isset($_GET["urltoken"]) ? $_GET["urltoken"] : NULL;
    
    //DBに接続
    $dsn = 'mysql:dbname=***;host=***';
	$user = '***';
	$password = '***';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    if(empty($urltoken)){
        header("Location: no_registration_mail");
        exit();
    }else{
        //flagが0の未登録者
		$sql = "SELECT * FROM m6_pre_mail2 WHERE urltoken=(:urltoken) AND flag =0";
        $stmt = $pdo->prepare($sql);
		$stmt -> bindParam(':urltoken', $urltoken, PDO::PARAM_STR);
		$stmt -> execute();
			
        //上記のコード実行で得られた情報の行数（0ならない、１ならある）
		$row_count = $stmt -> rowCount();
			
		if($row_count == 1){ //本登録されていないトークンの場合
				$mails = $stmt -> fetch();
                $newmail = $mails["mail"];

		}else{
            header("Location: timeover_mail");
            exit();
		}
    }

    $report = $_POST["report"];
    $session_id = $_SESSION["id"];

    if(isset($report)){
        $sql = $pdo -> prepare("UPDATE m6_login SET mailreport=1 WHERE id='$session_id'");
            $sql->execute();
        $sql = $pdo -> prepare("UPDATE m6_pre_mail2 SET flag=1 WHERE urltoken='$urltoken'");
            $sql->execute();
    }
?>


<!--=========以下、表示部分=========-->

<?php if(isset($report)) : ?>
    <h2 color="red">通報致しました</h2>

<?php else : ?>
メールアドレスが変更されました。身に覚えがない場合は通報ボタンを押してください。

<form action = "" method = "post">
    <input type = "submit" name= "report" value = "通報" style = "width:200px; height:30px; font-size:15px;">
</form>

<?php endif ; ?>
    
</body>
</html>