<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規本登録｜SHARE BRAINS</title>
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

//===================================sessionの作り方を今度考える===================================

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
        //flagが0の未登録者 and 仮登録日から24時間以内
		$sql = "SELECT mail FROM m6_pre_login WHERE urltoken=(:urltoken) AND flag =0 AND date > now() - interval 24 hour";
        $stmt = $pdo->prepare($sql);
		$stmt -> bindParam(':urltoken', $urltoken, PDO::PARAM_STR);
		$stmt -> execute();
			
        //上記のコード実行で得られた情報の行数（0ならない、１ならある）
		$row_count = $stmt -> rowCount();
			
		if($row_count == 1){ //24時間以内に仮登録され、本登録されていないトークンの場合
				$mails = $stmt -> fetch();
                $mailad = $mails["mail"];

		}else{
            header("Location: timeover_mail");
            exit();
		}
    }

//====================================入力コード====================================
//定義
    $pattern = '/^[ァ-ヶｦ-ﾟー]+$/u';
    $pattern2 = '/^[a-zA-Z0-9._]{5,20}$/';
    $pattern3 = '/^[a-zA-Z0-9]{6,12}$/';
    $familyname = $_POST["familyname"];
    $firstname = $_POST["firstname"];
    $familyname2 = $_POST["familyname2"];
    $firstname2 = $_POST["firstname2"];
    $userid = $_POST["userid"];
    $birthY = $_POST["birthY"];
    $birthM = $_POST["birthM"];
    $birthD = $_POST["birthD"];
    $pass = $_POST["pass"];
    $pass2 = $_POST["passcheck"];
    $ok = $_POST["ok"];
    $ok2 = NULL;
    $ok4 = NULL;


    if(isset($ok)){//次のページへボタンが押されたとき
        if($familyname != NULL && $firstname != NULL && $familyname2 != NULL && $firstname2 != NULL && $userid != NULL && $birthY != NULL && $birthM != NULL && $birthD != NULL && $pass != NULL && $pass2 != NULL && preg_match($pattern, $familyname2) && preg_match($pattern, $firstname2) && $pass == $pass2 && preg_match($pattern3,$pass)){
            $ok2 = "くりあ"; 
        }
        if($familyname == NULL or $firstname == NULL){
            $miss1 = "※お名前をフルネームでご入力下さい";
        }
        if($familyname2 == NULL or $firstname2 == NULL){
            $miss2 = "※お名前をフルネームでご入力下さい";
        }elseif(!preg_match($pattern,$familyname2) or !preg_match($pattern,$firstname2)){
            $miss3 = "※全角カタカナのみです";
        }
        if($userid == NULL){
            $miss8 = "※ユーザーIDをご入力下さい";
        }elseif(!preg_match($pattern2,$userid)){
            $miss10 = "※不正な形式のユーザーIDです";
        }else{
            $sql = 'SELECT * FROM m6_login';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach($results as $row){
                if($userid == $row['userid']){
                    $miss9 = "※すでに登録されたユーザIDです";
                }else{
                    $ok4 = "くりあ";
                }
            }
        }
        if($birthY == NULL or $birthM == NULL or $birthD == NULL){
            $miss4 = "※生年月日を全てご入力下さい";
        }
        if($pass == NULL or $pass2 == NULL){
            $miss5 = "※パスワードをご入力下さい";
        }elseif($pass != $pass2){
            $miss6 = "※パスワードが一致しません";
        }elseif(!preg_match($pattern3,$pass)){
            $miss11 = "※6~12文字以上で設定して下さい";
        }
    }


//====================================確認コード====================================
    $go = $_POST["go"];
    $password_hide = str_repeat('*', strlen($pass));
    $familyname_2 = $_POST["familyname_2"];
    $firstname_2 = $_POST["firstname_2"];
    $name = $familyname_2.$firstname_2;
    $familyname2_2 = $_POST["familyname2_2"];
    $firstname2_2 = $_POST["firstname2_2"];
    $name2 = $familyname2_2.$firstname2_2;
    $userid_2 = $_POST["userid_2"];
    $birthY_2 = $_POST["birthY_2"];
    $birthM_2 = $_POST["birthM_2"];
    $birthD_2 = $_POST["birthD_2"];
    $birth = $birthY_2."/".$birthM_2."/".$birthD_2;
    $pass_2 = $_POST["pass_2"];
    $password_hash =  password_hash($_POST["pass_2"], PASSWORD_DEFAULT);
    $_SESSION['familyname'] = $familyname;
    $body = $name."さん<br>本登録ありがとうございます！<br>ログインページURL：https://tb-220294.tech-base.net/mission6_login.php<br>あなたのユーザーID：".$userid_2;
    $subject = "本登録完了のお知らせ";
    $ok3 = NULL;

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
    $mail->Subject = $subject; // メールタイトル
    $mail->isHTML(true);    // HTMLフォーマットの場合はコチラを設定します
    $mail->Body  = $body; // メール本文

    if(isset($go)){
        if(!$mail->send()) {
            $miss7 = 'メッセージは送られませんでした！';
            $missre = 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            $ok3 = "くりあ";
            try{
                $sql = $pdo -> prepare("INSERT INTO m6_login (name, name2, userid, birth, password, mail, status, created_at, updated_at, filenum, mailreport) VALUES (:name, :name2, :userid, :birth, :password, :mail, 1, now(), now(), 0, 0)");
                $sql->bindParam(':name', $name, PDO::PARAM_STR);
                $sql->bindParam(':name2', $name2, PDO::PARAM_STR);
                $sql->bindParam(':userid', $userid_2, PDO::PARAM_STR);
                $sql->bindParam(':birth', $birth, PDO::PARAM_STR);
                $sql->bindParam(':password', $password_hash, PDO::PARAM_STR);
                $sql->bindParam(':mail', $mailad, PDO::PARAM_STR);
                $sql->execute();

                $sql = $pdo->prepare("UPDATE m6_pre_login SET flag=1 WHERE mail=:mail");
                $sql -> bindValue(':mail', $mailad, PDO::PARAM_STR);
		        $sql -> execute();
            }catch (PDOException $e){
                print('Error:'.$e->getMessage());
                exit();
            }
        }          
    }
?>

<!--====================================完了ページ====================================-->
<?php if($ok3 != NULL) : ?>
    <h1>本登録完了！</h1><hr>
    登録は完了しました。ありがとうございます！<br>
    完了メールを登録されたアドレスに送信しました。<br>
    <button onclick="location.href='https://tb-220294.tech-base.net/mission6_login.php'" style = "width:150px; background-color:steelblue; color:white;">ログインページへ>></button>

<!--====================================確認ページ====================================-->
<?php elseif($ok2 != NULL && $ok4 != NULL) : ?>
    <h1>本登録確認画面</h1><hr>
<form action = "" method = post>
    <div class = "title"><h3>メールアドレス</h3></div>
    <?php echo $mailad; ?><br>

    <div class = "title"><h3>氏名</h3></div>
    <input type = "hidden" name = "familyname_2"  value = "<?php echo $familyname; ?>">
    <input type = "hidden" name = "firstname_2"  value = "<?php echo $firstname; ?>">
    <?php echo $familyname."　".$firstname."<br>"; ?>

    <div class = "title"><h3>氏名カナ</h3></div>
    <input type = "hidden" name = "familyname2_2"  value = "<?php echo $familyname2; ?>">
    <input type = "hidden" name = "firstname2_2"  value = "<?php echo $firstname2; ?>" >
    <?php echo $familyname2."　".$firstname2."<br>"; ?>

    <div class = "title"><h3>ユーザーID</h3></div>
    <input type = "hidden" name = "userid_2"  value = "<?php echo $userid; ?>">
    <?php echo $userid."<br>"; ?>

    <div class = "title"><h3>生年月日</h3></div>
    <input type = "hidden" name = "birthY_2" value = "<?php echo $birthY; ?>">
    <input type = "hidden" name = "birthM_2" value = "<?php echo $birthM; ?>">
    <input type = "hidden" name = "birthD_2" value = "<?php echo $birthD; ?>">
    <?php echo $birthY."/".$birthM."/".$birthD."<br>"; ?>

    <div class = "title"><h3>パスワード</h3></div>
    <input type = "hidden" name = "pass_2" value = "<?php echo $pass; ?>">
    <?php echo $password_hide."（あなたが設定したパスワード）" ?><br><br>
    <hr style = "border:0.5px dashed silver">

    内容を確認しよろしければ登録を、修正したい場合は修正を押して下さい。<br>
    <input type = "submit" name = "edit" value = "修正" style = "width:120px;">
    <input type = "submit" name = "go" value = "登録" style = "width:120px; background-color:steelblue; color:white;">
    <?php echo $miss7 ; ?>
</form>

<!--====================================入力ページ====================================-->
<?php else : ?>
    
    <h1>新規本登録</h1><hr>
<form action = "" method = post>
    <div class = "title"><h3>メールアドレス</h3></div>
    <?php echo $mailad; ?><br><br>

    <div class = "title"><h3>氏名</h3></div>
    <input type = "text" name = "familyname" placeholder = "山田" value = "<?php echo $familyname; echo $familyname_2;?>">
    <input type = "text" name = "firstname" placeholder = "太郎" value = "<?php echo $firstname; echo $firstname_2;?>"><br>
    <div class = "error"><?php echo $miss1; echo "　";?><br></div>

    <div class = "title"><h3>氏名カナ</h3></div>
    <input type = "text" name = "familyname2" placeholder = "ヤマダ" value = "<?php echo $familyname2; echo $familyname2_2;?>">
    <input type = "text" name = "firstname2" placeholder = "タロウ" value = "<?php echo $firstname2; echo $firstname2_2; ?>"><br>
    <div class = "error"><?php echo $miss2; echo $miss3; echo "　";?><br></div>

    <div class = "title"><h3>ユーザーID</h3></div>
    <input type = "text" name = "userid" style = "width:200px;" value = "<?php echo $userid; echo $userid_2; ?>">　（5~20文字で半角英数字,ピリオド,アンダーバーのみです）
    <div class = "error"><?php echo $miss8; echo $miss9; echo $miss10; echo "　";?><br></div>

    <div class = "title"><h3>生年月日</h3></div>
    <input type = "text" name = "birthY" style = "width:70px;" value = "<?php echo $birthY; echo $birthY_2; ?>">年
    <input type = "number" name = "birthM" max = "12" min = "1" value = "<?php echo $birthM; echo $birthM_2; ?>">月
    <input type = "number" name = "birthD" max = "31" min = "1" value = "<?php echo $_birthD; echo $birthD_2; ?>">日
    <div class = "error"><?php echo $miss4; echo "　";?><br></div>

    <div class = "title"><h3>パスワード</h3></div>
    <input type = "password" name = "pass" style = "width:320px;" placeholder = "パスワード" value = "<?php echo $pass; ?>">　（6~12文字で半角英数字のみです）<br>
    <input type = "password" name = "passcheck" style = "width:320px;" placeholder = "確認用" value = "<?php echo $pass2; ?>">　確認のためもう一度ご入力下さい。<br>
    <div class = "error"><?php echo $miss5; echo $miss6; echo $miss11; echo "　";?><br></div>
    <hr style = "border:0.5px dashed silver">

    内容を確認し、よろしければ次のページへお進み下さい。<br>
    <input type = "submit" name = "ok" value = "次のページへ>>" style = "width:120px; background-color:steelblue; color:white;">
</form>

<?php endif; ?>

<form action = "" method =post>
    <input type = "hidden" name = "token" value = "<?php echo $urltoken; ?>" >
</form>

</body>
</html>