<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>SHARE BRAINS｜質問編集ページ</title>

    <style>  
    .title{
        border-left : 8px solid steelblue;
        padding-left : 10px;
    }
    .title2{
        border-left : 8px solid red;
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
        //DBに接続
        $dsn = 'mysql:dbname=***;host=***';
        $user = '***';
        $password = '***';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));       

        $subject = $_POST["subject"];
        $unit = $_POST["unit"];
        $q = $_POST["q"];
        $file_name = $_FILES["file"]["name"];
        $file_tmp = $_FILES['file']['tmp_name'];
        $image = uniqid(mt_rand(), true);//ファイル名をユニーク化
        $image .= '.' . substr(strrchr($file_name, '.'), 1);//アップロードされたファイルの拡張子を取得
        $noimage = "noimage";
        $delatefile = $_POST["delatefile"];
        $editeditfile = $_POST["editeditfile"];
        $noname = $_POST["noname"];
        $send = $_POST["send"];
        $qnum = $_POST["qnum"];
        $moreq = $_POST["moreq"];
        $delate = $_POST["delate"];
        $clear = $_POST["clear"];
        $go = NULL;

        $sql = "SELECT * FROM m6_query WHERE id='$qnum'";
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            $row_id = $row['id'];
            $row_noname = $row['noname'];
            $row_subject = $row['subject'];
            $row_unit = $row['unit'];
            $row_question = $row['question'];
            $row_filename = $row['filename'];
            $row_editfile = $row['editfile'];
            $row_delatefile = $row['delatefile'];
        }
        
        if(isset($send)){
            if($row_delatefile == 0 || $row_delatefile == NULL){
                if(isset($subject)){
                    if($unit != NULL && $q != NULL){       
                        $go = "質問送信";
                        $sql = $pdo -> prepare("UPDATE m6_query SET noname=:noname, subject=:subject, unit=:unit, question=:question WHERE id='$qnum'" );                       
                            $sql -> bindParam(':noname', $noname, PDO::PARAM_INT); 
                            $sql -> bindParam(':subject', $subject, PDO::PARAM_STR);
                            $sql -> bindParam(':unit', $unit, PDO::PARAM_STR);
                            $sql -> bindParam(':question', $q, PDO::PARAM_STR);
                            $sql -> execute();
                    }
                }else{
                    $miss1 = "※教科を選択して下さい";
                }
                if($unit == NULL){
                    $miss2 = "※単元範囲を入力して下さい";
                }
                if($q == NULL){
                    $miss3 = "※質問を入力して下さい";
                }
                if(!empty($file_name) && $go == NULL){
                    $miss4 = "※改めて画像ファイルを選択して下さい";
                } 
            }else{
	            $sql = 'delete from m6_query where id=:id';
	            $stmt = $pdo->prepare($sql);
	            $stmt->bindParam(':id', $qnum, PDO::PARAM_INT);
                $stmt->execute();
                header( "Location: https://tb-220294.tech-base.net/mission6_main_editQ_delate.php" ) ;
	            exit ;
            }
        }

        if($go != NULL){
            if($row_editfile == 1 && empty($file_name)){
                $sql = $pdo -> prepare("UPDATE m6_query SET filename=:filename, editfile=0 WHERE id='$qnum'" );                       
                    $sql -> bindParam(':filename', $noimage, PDO::PARAM_STR); 
                    $sql -> execute();
            }elseif(!empty($file_name)){
                $sql = $pdo -> prepare("UPDATE m6_query SET filename=:filename, editfile=0 WHERE id='$qnum'" );
                    $sql -> bindParam(':filename', $image, PDO::PARAM_STR);
                    move_uploaded_file($file_tmp,'./images/'.$image);//imagesディレクトリにファイル保存
                    $sql -> execute();
            }
        }
        

        
        if(isset($delatefile)){
            $sql = "UPDATE m6_query SET editfile='1' WHERE id='$qnum'";
            $stmt = $pdo->query($sql);
        }

        if(isset($editeditfile)){
            $sql = "UPDATE m6_query SET editfile='0' WHERE id='$qnum'";
            $stmt = $pdo->query($sql);
        }

        if(isset($delate)){
            $sql = "UPDATE m6_query SET delatefile='1' WHERE id='$qnum'";
            $stmt = $pdo->query($sql);
        }

        if(isset($clear)){
            $sql = "UPDATE m6_query SET delatefile='0' WHERE id='$qnum'";
            $stmt = $pdo->query($sql);
        }
        
    ?>

    <?php
        $sql = "SELECT * FROM m6_query WHERE id='$qnum'";
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            $row_id = $row['id'];
            $row_noname = $row['noname'];
            $row_subject = $row['subject'];
            $row_unit = $row['unit'];
            $row_question = $row['question'];
            $row_filename = $row['filename'];
            $row_editfile = $row['editfile'];
            $row_delatefile = $row['delatefile'];
    ?>

<!--============以下、表示部分===========-->

            <form action = "" method = "post" enctype = "multipart/form-data">
    
    <?php if($row_delatefile == 1) : ?>
        <div class = "title2">質問を元に戻す</div><hr>
            <br><input type = "submit" name = "clear" value = "元に戻す" style = "width:80px;"><br><br><hr><hr>

        完了ボタンを押すと質問は削除されます<br>
            <input type = "submit" name = "send" value = "完了" style = "width:80px;">　
            <br><hr><hr>
            <input type = "hidden" name = "qnum" value = "<?php echo $qnum; ?>">

    <?php elseif($row_delatefile == 0) : ?>

        <?php if(isset($send) && $go != NULL) : ?>
            <h1 style = color:red>質問内容の編集が完了しました</h1>
        <?php endif ; ?>

                <hr><div class = "title">教科名（必須）</div><hr>
                    <div class = "error"><?php echo $miss1; echo "　"; ?></div>
                    <label><input type = "radio" name = "subject" value = "国語" <?php if(isset($send)){if($subject == "国語"){echo "checked";}}elseif($row_subject == "国語"){echo "checked";} ?>>国語</label>
                    <label><input type = "radio" name = "subject" value = "算数" <?php if(isset($send)){if($subject == "算数"){echo "checked";}}elseif($row_subject == "算数"){echo "checked";} ?>>算数</label>
                    <label><input type = "radio" name = "subject" value = "数学" <?php if(isset($send)){if($subject == "数学"){echo "checked";}}elseif($row_subject == "数学"){echo "checked";} ?>>数学</label>
                    <label><input type = "radio" name = "subject" value = "英語" <?php if(isset($send)){if($subject == "英語"){echo "checked";}}elseif($row_subject == "英語"){echo "checked";} ?>>英語</label>
                    <label><input type = "radio" name = "subject" value = "理科" <?php if(isset($send)){if($subject == "理科"){echo "checked";}}elseif($row_subject == "理科"){echo "checked";} ?>>理科</label>
                    <label><input type = "radio" name = "subject" value = "社会" <?php if(isset($send)){if($subject == "社会"){echo "checked";}}elseif($row_subject == "社会"){echo "checked";} ?>>社会</label>
                    <label><input type = "radio" name = "subject" value = "その他" <?php if(isset($send)){if($subject == "その他"){echo "checked";}}elseif($row_subject == "その他"){echo "checked";} ?>>その他</label><br><br><hr>

                <div class = "title">単元範囲（必須）</div><hr>
                    <div class = "error"><?php echo $miss2; echo "　"; ?></div>
                    <input type = "text" name = "unit" placeholder = "現代文、三角関数、英作文..." style = "width:300px;" value = "<?php if(isset($send)){echo $unit;}else{echo $row_unit;} ?>"><br><br><hr>
    
                <div class = "title">質問内容（必須）</div><hr>
                    <div class = "error"><?php echo $miss3; ?></div>
                    <textarea name = "q" rows = "8" cols = "60"><?php if(isset($send)){echo $q;}else{echo $row_question;}?></textarea><br><hr>

                <div class = "title">問題の画像（任意）</div><hr>
                    <?php if($row_filename == "noimage" || $row_editfile == "1") : ?>
                        <div class = "error"><?php echo $miss4; echo "　";?></div>
                        <input type = "file" name = "file" accept = "image/*"><br>

                        <?php if($row_filename != "noimage") : ?>
                            <br><input type = "submit" name = "editeditfile" value = "元に戻す" style = "width:100px;">
                        <?php endif ; ?>
                                              
                    <?php else : ?>
                        <img src="images/<?php echo $row_filename ; ?>" width="300" height="300"><br><br>
                        <input type = "submit" name = "delatefile" value = "画像削除" style = "width:100px;"><br>
                    
                    <?php endif ; ?>
                    <br><hr>

                <div class = "title2">質問を削除する</div><hr>
                    <br><input type = "submit" name = "delate" value = "質問削除" style = "width:80px;"><br><br><hr><hr>

                内容を確認し、よろしければ完了ボタンを押して下さい（完了ボタンを押さないと反映されません）<br>
                    <input type = "submit" name = "send" value = "完了" style = "width:80px;">　
                    <label><input type = "checkbox" name = "noname" value = "1" <?php if(isset($send)){if($noname != NULL){echo "checked";}}elseif($row_noname == "1"){echo "checked";} ?>>匿名で質問する</label>
                    <br><hr><hr>
                    <input type = "hidden" name = "qnum" value = "<?php echo $qnum; ?>">
            </form>

    <?php endif ; ?>

<!--============以上、表示部分===========-->

    <?php
        }
    ?>


   
</body>
</html>