<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>メール変更本登録｜SHARE BRAINS</title>
    
</head>
<body>

<?php

error_reporting(E_ALL & ~E_NOTICE); //Noticeを表示させない
session_start();

//全体に関する定義
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
        //flagが0の未登録者 and 仮登録日から5分以内
		$sql = "SELECT mail FROM m6_pre_mail WHERE urltoken=(:urltoken) AND flag =0 AND date > now() - interval 5 minute";
        $stmt = $pdo->prepare($sql);
		$stmt -> bindParam(':urltoken', $urltoken, PDO::PARAM_STR);
		$stmt -> execute();
			
        //上記のコード実行で得られた情報の行数（0ならない、１ならある）
		$row_count = $stmt -> rowCount();
			
		if($row_count == 1){ //5分以内に仮登録され、本登録されていないトークンの場合
				$mails = $stmt -> fetch();
                $newmail = $mails["mail"];

		}else{
            header("Location: timeover_mail");
            exit();
		}
    }

    $session_id = $_SESSION["id"];
    $urltoken = hash('sha256',uniqid(rand(),1));
    $url = "https://tb-220294.tech-base.net/mission6_main_mail_2.php?urltoken=".$urltoken;
    $subject = "メールアドレス変更のお知らせ";
    $body = "メールアドレスが変更されました。覚えのない場合は以下のURLから通報を行なって下さい。<br>".$url;
    $update = $_POST["update"];
    $report = $_POST["report"];
    $sql = "SELECT * FROM m6_login WHERE id='$session_id'";
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            $row_mail = $row["mail"];
        }
    $sql = "SELECT * FROM m6_pre_mail WHERE usernum='$session_id'";
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            $row_mail_new = $row["mail"];
        }

    //Mailarの読み込み
    require 'src/Exception.php';
    require 'src/PHPMailer.php';
    require 'src/SMTP.php';
    require 'setting.php'; //定義したファイルの読み込み

    // PHPMailerのインスタンス生成
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $mail->isSMTP(); // SMTPを使うようにメーラーを設定する
    $mail->SMTPAuth = true;
    $mail->Host = MAIL_HOST; // メインのSMTPサーバー（メールホスト名）を指定
    $mail->Username = MAIL_USERNAME; // SMTPユーザー名（メールユーザー名）
    $mail->Password = MAIL_PASSWORD; // SMTPパスワード（メールパスワード）
    $mail->SMTPSecure = MAIL_ENCRPT; // TLS暗号化を有効にし、「SSL」も受け入れます
    $mail->Port = SMTP_PORT; // 接続するTCPポート

    // メール内容設定
    $mail->CharSet = "***";
    $mail->Encoding = "***";
    $mail->setFrom(MAIL_FROM,MAIL_FROM_NAME);
    $mail->addAddress($row_mail); //受信者（送信先）を追加する
    $mail->Subject = $subject; // メールタイトル
    $mail->isHTML(true);    // HTMLフォーマットの場合はコチラを設定します
    $mail->Body  = $body; // メール本文

    if(isset($update)){
        if(!$mail->send()){
            $miss = '※メッセージは送られませんでした！';
            $missre = 'Mailer Error: ' . $mail->ErrorInfo;
        }else{   
            $go = "クリア";
            //ここでデータベースに登録する
            try{
                //例外処理を投げる（スロー）ようにする
                $sql = $pdo -> prepare("UPDATE m6_login SET mail=:mail WHERE id='$session_id'");
                $sql->bindParam(':mail', $row_mail_new, PDO::PARAM_STR);
                    $sql->execute();
                $sql = $pdo -> prepare("UPDATE m6_pre_mail SET flag=1 WHERE usernum='$session_id'");
                    $sql->execute();
                $sql = $pdo -> prepare("INSERT INTO m6_pre_mail2 (flag, urltoken) VALUES (0, :urltoken)");
                    $sql->bindParam(':urltoken', $urltoken, PDO::PARAM_STR);
                    $sql->execute();
            }catch (PDOException $e){
                print('Error:'.$e->getMessage());
                exit();
            }
        }
    }
    
    if(isset($report)){
        $sql = $pdo -> prepare("UPDATE m6_login SET mailreport=1 WHERE id='$session_id'");
            $sql->execute();
        $sql = $pdo -> prepare("UPDATE m6_pre_mail SET flag=1 WHERE usernum='$session_id'");
            $sql->execute();
    }


?>

<!--=========以下、表示部分=========-->

<?php if(isset($update)) : ?>
    <h2 color="red">メールアドレスは更新されました！</h2>
    <form action = "https://tb-220294.tech-base.net/mission6_main2.php" method = "post">
        <input type = "submit" name = "updatetomain" value = "メインページに戻る>>" style = "width:200px; height:30px; font-size:15px;">　
    </form>

<?php elseif(isset($report)) : ?>
    <h2 color="red">通報致しました</h2>

<?php else : ?>
メールアドレスの登録を変更する場合は更新ボタンを、身に覚えがない場合は通報ボタンを押してください。

<form action = "" method = "post">
    <input type = "submit" name = "update" value = "更新" style = "width:200px; height:30px; font-size:15px;">　
    <input type = "submit" name= "report" value = "通報" style = "width:200px; height:30px; font-size:15px;">
</form>

<?php endif ; ?>
    
</body>
</html>