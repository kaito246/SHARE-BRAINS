<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規仮登録｜SHARE BRAINS</title>   
    <style>
        .title{
            border-left : 8px solid steelblue;
            padding-left : 10px;
        }
    </style>
</head>
<body>

    <?php

    error_reporting(E_ALL & ~E_NOTICE); //Noticeを表示させない

        $mailad = $_POST["mailadress"];
        $mailch = $_POST["mailcheck"];
        $check = $_POST["check"];
        $pattern = "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/";
        $urltoken = hash('sha256',uniqid(rand(),1));
        $url = "https://tb-220294.tech-base.net/mission6_new.php?urltoken=".$urltoken;
        $body = "この度は「SHARE BRAINS」にご登録いただきありがとうございます。<br>".
                "本登録はまだ完了しておりません。下記のURLから本登録をお願いします。<br>".
                "URLの有効期限は24時間となっておりますのでお気をつけ下さい。<br>".
                $url;
        $go = NULL;
        $c = NULL;
        $miss5 = NULL;


        //DBに接続
        $dsn = 'mysql:dbname=***;host=***';
	    $user = '***';
	    $password = '***';
	    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

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
        $mail->addAddress($mailad); //受信者（送信先）を追加する
        $mail->Subject = MAIL_SUBJECT; // メールタイトル
        $mail->isHTML(true);    // HTMLフォーマットの場合はコチラを設定します
        $mail->Body  = $body; // メール本文

        if(isset($check)){
            if($mailad != NULL && $mailch != NULL){
                if(preg_match($pattern, $mailad)){
                    if($mailad == $mailch){
                        $sql = 'SELECT * FROM m6_login';
                        $stmt = $pdo->query($sql);
                        $results = $stmt->fetchAll();
                        foreach($results as $row){
                            if($mailad == $row['mail']){
                                $miss5 = "※すでに登録されたメールアドレスです";
                            }else{
                                $c = "くりあ";
                            }
                        }
                        if($c != NULL && $miss5 == NULL){
                            if(!$mail->send()){
                                $miss = '※メッセージは送られませんでした！';
                                $missre = 'Mailer Error: ' . $mail->ErrorInfo;
                            }else{   
                                $go = "クリア";
                                //ここでデータベースに登録する
                                try{
                                    //例外処理を投げる（スロー）ようにする
                                    $sql = $pdo -> prepare("INSERT INTO m6_pre_login (urltoken, mail, date, flag) VALUES (:urltoken, :mail, now(), '0')");
                                    $sql->bindParam(':urltoken', $urltoken, PDO::PARAM_STR);
                                    $sql->bindValue(':mail', $mailad, PDO::PARAM_STR);
                                    $sql->execute();
                                }catch (PDOException $e){
                                    print('Error:'.$e->getMessage());
                                    exit();
                                }
                            }
                        }              
                    }else{
                        $miss2 = "※メールアドレスが一致しません";
                    }
                }else{
                    $miss4 = "※不正な形式のメールアドレスです";
                }
            }else{
                $miss3 = "※記入ミスがあります";
            }
        }
    ?>

    <h1>新規仮登録</h1><hr>

<?php if($go != NULL) : ?>
    登録いただいたアドレスにメールをお送りしました。<br>
    本登録はまだ完了しておりません。お送りしたメールのURLから本登録をお済ませ下さい。<br>
    添付したURLの有効期限は24時間となっております。

<?php else : ?>
    <form action = "" method = post>
        
        <div class = "title"><h3>メールアドレス</h3></div>
        <input type = "text" name = "mailadress" style = "width:320px;" placeholder = "メールアドレス" value = "<?php echo $mailad; ?>"><br>
        <input type = "text" name = "mailcheck" style = "width:320px;" placeholder = "確認用" value = "<?php echo $mailch; ?>">　確認のためもう一度ご入力下さい。<br><br>
        <hr style = "border:0.5px dashed silver">

        ご入力いただいたアドレスへ確認メールを送ります。よろしければ送信ボタンを押して下さい。<br>
        <input type = "submit" name = "check" value = "送信" style = "width:100px; background-color:steelblue; color:white;" >
        <span style = color:red><?php echo $miss; echo $missre; echo $miss2; echo $miss3; echo $miss4; echo $miss5; ?></span>
    </form>
<?php endif ; ?>
</body>
</html>