<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>メールアドレス変更｜SHARE BRAINS</title>

    <style>
        .title{
            border-left : 8px solid steelblue;
            padding-left : 10px;
        }
        .error{
            color : red;
        }
    </style>
    
</head>
<body>

    <?php
        error_reporting(E_ALL & ~E_NOTICE); //Noticeを表示させない
    ?>


    <?php if(!isset($_SESSION["userid"])) : ?>
        <script language="javascript" type="text/javascript">
            alert('セッションが無効です');
            location.href = "https://tb-220294.tech-base.net/mission6_login.php";
        </script>
    <?php endif ; ?>

    <?php

    //DBに接続
    $dsn = 'mysql:dbname=***;host=***';
    $user = '***';
    $password = '***';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    $session_id = $_SESSION["id"];
    $send = $_POST["send"];
    $newmail = $_POST["newmail"];
    $nowmail = $_POST["nowmail"];
    $mailcheck = $_POST["mailcheck"];
    $urltoken = hash('sha256',uniqid(rand(),1));
    $url = "https://tb-220294.tech-base.net/mission6_main_mail_1.php?urltoken=".$urltoken;
    $subject = "メールアドレス変更の本登録";
    $body = "以下のURLからメールアドレス変更の本登録を行なって下さい。<br><br>なおURLの有効期限は5分となっておりますのでご注意ください。<br>".$url;
    $pattern = "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/";

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
    $mail->addAddress($newmail); //受信者（送信先）を追加する
    $mail->Subject = $subject; // メールタイトル
    $mail->isHTML(true);    // HTMLフォーマットの場合はコチラを設定します
    $mail->Body  = $body; // メール本文

    if(isset($send)){

        if($nowmail == NULL){
            $miss2 = "※アドレスを入力してください";
        }elseif(!preg_match($pattern, $nowmail)){
            $miss4 = "※不正な形式のメールアドレスです";
        }

        if($newmail == NULL || $mailcheck == NULL){
            $miss1 = "※アドレスを入力してください";
        }elseif(!preg_match($pattern, $newmail)){
            $miss3 = "※不正な形式のメールアドレスです";
        }

        $sql = 'SELECT * FROM m6_login';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach($results as $row){
            if($newmail == $row['mail']){
                $miss6 = "※すでに登録されたメールアドレスです";
            }else{
                $c = "くりあ";
            }
        }

        $sql = "SELECT * FROM m6_login WHERE id='$session_id'";
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach($results as $row){
            if($nowmail != $row['mail'] && $nowmail != NULL && preg_match($pattern, $nowmail)){
                $miss7 = "※メールアドレスが違います";
            }else{
                $c2 = "くりあ";
            }
        }

        if($nowmail != NULL && $newmail != NULL && $mailcheck != NULL){
            if(preg_match($pattern, $nowmail) && preg_match($pattern, $newmail)){
                if($newmail == $mailcheck){    
                    if($c != NULL && $c2 != NULL && $miss6 == NULL && $miss7 == NULL){
                        if(!$mail->send()){
                            $miss = '※メッセージは送られませんでした！';
                            $missre = 'Mailer Error: ' . $mail->ErrorInfo;
                        }else{   
                            $go = "クリア";
                            //ここでデータベースに登録する
                            try{
                                //例外処理を投げる（スロー）ようにする
                                $sql = $pdo -> prepare("INSERT INTO m6_pre_mail (urltoken, mail, usernum, flag, date) VALUES (:urltoken, :mail, :usernum, '0', now())");
                                $sql->bindParam(':urltoken', $urltoken, PDO::PARAM_STR);
                                $sql->bindValue(':mail', $newmail, PDO::PARAM_STR);
                                $sql->bindValue(':usernum', $session_id, PDO::PARAM_INT);
                                $sql->execute();
                            }catch (PDOException $e){
                                print('Error:'.$e->getMessage());
                                exit();
                            }
                        }
                    }              
                }else{
                    $miss5 = "※メールアドレスが一致しません";
                }
            }
        }
    }

    ?>




<!--====================表示画面===================-->

<?php if($go != NULL) : ?>
    <h1 style="color:red">変更されたアドレスにメールを送信しました（変更はまだ完了していません）<br>メールに添付されているURLの有効期限は5分です。</h1>
    <form action = "https://tb-220294.tech-base.net/mission6_main2.php" method = post>
        <input type = "submit" name = "mailtomain" value = "メインメニューへ戻る>>">
    </form>

<?php else : ?>

    <?php echo $miss; echo $missre;?>
    <form action = "" method = post>

    <div class = "title"><h3>現在のメールアドレス</h3></div>
        <div class = "error"><?php echo $miss2; echo $miss4; echo $miss7; echo "　";?></div>
        <input type = "text" name = "nowmail" style = "width:320px;" placeholder = "現在のメールアドレス" value = "<?php echo $nowmail; ?>"><br><br><br>
    <div class = "title"><h3>新しいメールアドレス</h3></div>
        <div class = "error"><?php echo $miss1; echo $miss3; echo $miss5; echo $miss6; echo "　";?></div>
        <input type = "text" name = "newmail" style = "width:320px;" placeholder = "新しいメールアドレス" value = "<?php echo $newmail; ?>"><br>
        <input type = "text" name = "mailcheck" style = "width:320px;" placeholder = "確認用" value = "<?php echo $mailcheck; ?>">　確認のためもう一度ご入力下さい。<br><br><br>
        <hr style = "border:0.5px dashed silver">

    <div style="display:inline-flex">
        <input type = "submit" name = "send" value = "送信" style = "width:120px; background-color:steelblue; color:white;">　
    </form>
    <form action = "https://tb-220294.tech-base.net/mission6_main2.php" method = post>
        <input type = "submit" name = "mailtomain" value = "メインメニューへ戻る>>">
    </form>
    </div>

<?php endif ; ?>
    
</body>
</html>