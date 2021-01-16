<?php 
    session_start(); 
    error_reporting(E_ALL & ~E_NOTICE); //Noticeを表示させない

    //=================================グループページ=================================
    $grouptomain = $_POST["grouptomain"];
    $groupid = $_POST["groupid"];
    $togroup = $_POST["togroup"];

    if(isset($_POST["togroup"])){
        $_SESSION["groupid"] = $groupid;
        header("Location:https://tb-220294.tech-base.net/mission6_main_group.php");
        exit();
    }   
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>SHARE BRAINS</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.4/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js" type="text/javascript"></script>

    <style>
    .main{
        float: left;
        width: 73%;
    }
    .sub{
        float: right;
        width: 26%;
        border-left: 1px solid #818181;
        padding-left: 5px;
        position:fixed;
        right:0%;
        border-bottom: 1px solid #818181;
        padding-bottom: 10px;
    }
    .title{
        border-left : 8px solid steelblue;
        padding-left : 10px;
    }
    .error{
        color : red;
    }
    .name{
        font-weight : bold;
    }
    .time{
        font-size : 15px;
        color : gray
    }
    .good{
        font-size : 20px;
        color : red;
    }
    .userfile{
        text-align : center;
    }
    #page_top{
        width: 90px;
        height: 90px;
        position: fixed;
        right: 27%;
        bottom: 0;
        opacity: 0.6;
    }
    #page_top a{
        position: relative;
        display: block;
        width: 90px;
        height: 90px;
        text-decoration: none;
    }
    #page_top a::before{
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        content: '\f102';
        font-size: 25px;
        color: steelblue;
        position: absolute;
        width: 25px;
        height: 25px;
        top: -40px;
        bottom: 0;
        right: 0;
        left: 0;
        margin: auto;
        text-align: center;
    }
    #page_top a::after{
        content: 'PAGE TOP';
        font-size: 13px;
        color: #fff;
        position: absolute;
        top: 45px;
        bottom: 0;
        right: 0;
        left: 0;
        margin: auto;
        text-align: center;
        color: steelblue;
    }
    .hidden_box{
        margin: 1em 0;
        padding: 0;
    }
    .hidden_box label {
        padding: 5px;
        font-size: 15px;
        background: #EEEEEE;
        border: solid 1px black;
        cursor :pointer;
        transition: .5s;
    }
    .hidden_box label:hover {
        background: #DDDDDD;
    }
    .hidden_box .hidden_show {
        height: 0;
        padding: 0;
        overflow: hidden;
        opacity: 0;
        transition: 0.8s;
    }
    .hidden_box input:checked ~ .hidden_show {
        padding: 10px 0;
        height: auto;
        opacity: 1;
    }
    .balloon {
        position: relative;
        display: inline-block;
        margin: 1.5em 0;
        padding: 7px 10px;
        min-width: 120px;
        max-width: 100%;
        color: #555;
        font-size: 16px;
        background: #FFF;
        border: solid 3px #555;
        box-sizing: border-box;
    }
    .balloon:before {
        content: "";
        position: absolute;
        bottom: -24px;
        left: 50%;
        margin-left: -15px;
        border: 12px solid transparent;
        border-top: 12px solid #FFF;
        z-index: 2;
    }
   .balloon:after {
        content: "";
        position: absolute;
        bottom: -30px;
        left: 50%;
        margin-left: -17px;
        border: 14px solid transparent;
        border-top: 14px solid #555;
        z-index: 1;
    }
    .balloon p {
       margin: 0;
       padding: 0;
    }
    .home {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        background: radial-gradient(1.5em 6.28571em at 1.95em, rgba(255, 255, 255, 0) 50%, rgba(255, 255, 255, 0.25) 50%, rgba(255, 255, 255, 0.25) 55%, rgba(255, 255, 255, 0) 55%) 0 0, radial-gradient(1.5em 6.28571em at -0.45em, rgba(255, 255, 255, 0) 50%, rgba(255, 255, 255, 0.25) 50%, rgba(255, 255, 255, 0.25) 55%, rgba(255, 255, 255, 0) 55%) 1.5em 5.5em, radial-gradient(2.3em 4.57143em at 2.99em, rgba(255, 255, 255, 0) 50%, rgba(255, 255, 255, 0.3) 50%, rgba(255, 255, 255, 0.3) 55%, rgba(255, 255, 255, 0) 55%) 0 0, radial-gradient(2.3em 4.57143em at -0.69em, rgba(255, 255, 255, 0) 50%, rgba(255, 255, 255, 0.3) 50%, rgba(255, 255, 255, 0.3) 55%, rgba(255, 255, 255, 0) 55%) 2.3em 4em, radial-gradient(3.5em 6.28571em at 4.55em, rgba(255, 255, 255, 0) 50%, rgba(255, 255, 255, 0.25) 50%, rgba(255, 255, 255, 0.25) 55%, rgba(255, 255, 255, 0) 55%) 0 0, radial-gradient(3.5em 6.28571em at -1.05em, rgba(255, 255, 255, 0) 50%, rgba(255, 255, 255, 0.25) 50%, rgba(255, 255, 255, 0.25) 55%, rgba(255, 255, 255, 0) 55%) 3.5em 5.5em, radial-gradient(#15ffa5, #00ced1);
        background-color: mediumspringgreen;
        background-size: 1.5em 11em, 1.5em 11em, 2.3em 8em, 2.3em 8em, 3.5em 11em, 3.5em 11em, 100% 100%;
        background-repeat: repeat;
        align-items: center;
        justify-content: center;
    }

    button.replycheck {
        font-size: 1.0em;
	    background-color: #A7F1FF;
        height: 25px;
        width: 60px;
        border: none
	}
    button.replycheck:hover {
	    background-color: #00ECFF;
	}
    .file_icon {
        vertical-align: middle ;
        display: inline-block;
    }
    </style>

    <script language="javascript" type="text/javascript">
    //トップへとぶボタンの作成-----------------
    jQuery(function() {
        var pagetop = $('#page_top');   
        pagetop.hide();
        $(window).scroll(function () {
            if($(this).scrollTop() > 200) {  //100pxスクロールしたら表示
                pagetop.fadeIn();
            }else{
                pagetop.fadeOut();
            }
        });
        pagetop.click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 500); //0.5秒かけてトップへ移動
            return false;
        });
    });

    //ラジオボタンの選択状態を消す方法-----------------
    $(function(){    
        var inputs = $('input'); //インプット要素を取得する
        var checked = inputs.filter(':checked').val(); //読み込み時に「:checked」の疑似クラスを持っているinputの値を取得する
        inputs.on('click', function(){ //読み込み時に「:checked」の疑似クラスを持っているinputの値を取得する
            if($(this).val() === checked) { //クリックされたinputとcheckedを比較
                $(this).prop('checked', false); //inputの「:checked」をfalse
                checked = ''; //checkedを初期化       
            }else{
                $(this).prop('checked', true); //inputの「:checked」をtrue
                checked = $(this).val(); //inputの値をcheckedに代入        
            }
        });    
    });
    </script>

</head>
<body>
<?php
error_reporting(E_ALL & ~E_NOTICE); //Noticeを表示させない
?>

<div id="page_top"><a href="#"></a></div>

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

if($_SESSION['userid'] != NULL){
    $sql = 'SELECT * FROM m6_login';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row2){
        if($row2["userid"] == $_SESSION["userid"]){
            $_SESSION["id"] = $row2["id"];
            $s_id = $_SESSION["id"];
            $_SESSION["name"] = $row2["name"];
            $_SESSION["name2"] = $row2["name2"];
            $_SESSION["birth"] = $row2["birth"];
            $_SESSION["password"] = $row2["password"];
            $_SESSION["mail"] = $row2["mail"];
            $_SESSION["created_at"] = $row2["created_at"];
            $_SESSION["updated_at"] = $row2["updated_at"];
            $_SESSION["filenum"] = $row2["filenum"];
        }
    }
}

//=================================ホーム画面=================================
    $setting = $_POST["setting"];
    $question = $_POST["question"];
    $question2 = $_POST["question2"];
    $answer = $_POST["answer"];
    $group = $_POST["group"];

//=================================質問一覧ページ=================================
    $subject2 = $_POST["subject2"];
    $unit2 = $_POST["unit2"];
    $serch = $_POST["serch"];
    $serchoff = $_POST["serchoff"];
    $unit2_2 = "/$unit2/";
    $solved = $_POST["solved"];

//=================================質問するページ=================================
    $subject = $_POST["subject"];
    $unit = $_POST["unit"];
    $q = $_POST["q"];
    $file_name = $_FILES["file"]["name"];
    $file_tmp = $_FILES['file']['tmp_name'];
    $image = uniqid(mt_rand(), true);//ファイル名をユニーク化
    $image .= '.' . substr(strrchr($file_name, '.'), 1);//アップロードされたファイルの拡張子を取得
    $noimage = "noimage";
    $noname = $_POST["noname"];
    $send = $_POST["send"];
    $moreq = $_POST["moreq"];
    $go = NULL;

    if(isset($send)){
        if(isset($subject)){
            if($unit != NULL && $q != NULL){       
                $go = "質問送信";
                $sql = $pdo -> prepare("INSERT INTO m6_query (userid, noname, subject, unit, question, filename, time, groupid, solve, editfile, delatefile) VALUES (:userid, :noname, :subject, :unit, :question, :filename, now(), 0, 0, 0, 0)");
                    $sql -> bindParam(':userid', $_SESSION["id"], PDO::PARAM_INT); 
                    $sql -> bindParam(':noname', $noname, PDO::PARAM_INT); 
                    $sql -> bindParam(':subject', $subject, PDO::PARAM_STR);
                    $sql -> bindParam(':unit', $unit, PDO::PARAM_STR);
                    $sql -> bindParam(':question', $q, PDO::PARAM_STR);
                    if(!empty($file_name)){
                        $sql -> bindParam(':filename', $image, PDO::PARAM_STR);
                        move_uploaded_file($file_tmp,'./images/'.$image);//imagesディレクトリにファイル保存
                    }else{
                        $sql -> bindParam(':filename', $noimage, PDO::PARAM_STR);
                    }
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
        if(!empty($file_name)){
            $miss4 = "※改めて画像ファイルを選択して下さい";
        }
    }

//=================================解答結果ページ=================================

    $subject3 = $_POST["subject3"];
    $unit3 = $_POST["unit3"];
    $serch2 = $_POST["serch2"];
    $serchoff2 = $_POST["serchoff2"];
    $unit3_2 = "/$unit3/";
    $solved2 = $_POST["solved2"];


    



//===================================設定ページ===================================
    $passtomain = $_POST["passtomain"];
    $editlogtomain = $_POST["editlogtomain"];
    $mailtomain = $_POST["mailtomain"];
    $updatetomain = $_POST["updatetomain"];
    
    $sql = "SELECT * FROM m6_query WHERE userid='$s_id'";
        $stmt = $pdo->prepare($sql);
		$stmt -> execute();
        $row_countQ = $stmt -> rowCount();
        
    $sql = "SELECT * FROM m6_answer WHERE aid='$s_id'";
        $stmt = $pdo->prepare($sql);
		$stmt -> execute();
        $row_countA = $stmt -> rowCount();
        
    $sql = "SELECT * FROM m6_answer WHERE aid='$s_id' AND good=2";
        $stmt = $pdo->prepare($sql);
		$stmt -> execute();
		$row_countSA = $stmt -> rowCount();
   
?>

<!--============================================メインページ=============================================-->

    <div class = "main">

<!--==========================質問一覧ページ=========================-->
    <?php if(isset($question2) or isset($serch) or isset($serchoff)) : ?>
    
        <form action = "" method = "post" enctype = "multipart/form-data">
            <hr><div class = "title">条件で絞る</div><hr>
            ＊教科：
                <label><input type = "radio" name = "subject2" value = "国語" <?php if(isset($serch) && $subject2 == "国語"){echo "checked";}?>>国語</label>
                <label><input type = "radio" name = "subject2" value = "算数" <?php if(isset($serch) && $subject2 == "算数"){echo "checked";}?>>算数</label>
                <label><input type = "radio" name = "subject2" value = "数学" <?php if(isset($serch) && $subject2 == "数学"){echo "checked";}?>>数学</label>
                <label><input type = "radio" name = "subject2" value = "英語" <?php if(isset($serch) && $subject2 == "英語"){echo "checked";}?>>英語</label>
                <label><input type = "radio" name = "subject2" value = "理科" <?php if(isset($serch) && $subject2 == "理科"){echo "checked";}?>>理科</label>
                <label><input type = "radio" name = "subject2" value = "社会" <?php if(isset($serch) && $subject2 == "社会"){echo "checked";}?>>社会</label>
                <label><input type = "radio" name = "subject2" value = "その他" <?php if(isset($serch) && $subject2 == "その他"){echo "checked";}?>>その他</label><br>
            ＊単元：
                <input type = "text" name = "unit2" placeholder = "現代文、三角関数、英作文..." style = "width:300px;" value = "<?php if(isset($serch)){echo $unit2;}?>"><br>
            ＊解決：
                <label><input type = "radio" name = "solved" value = "1" <?php if(isset($serch) && $solved == '1'){echo "checked";}?>>解決済み</label>
                <label><input type = "radio" name = "solved" value = "0" <?php if(isset($serch) && $solved == '0'){echo "checked";}?>>未解決</label><br>
                <input type ="submit" name = "serch" value = "🔎検索">　
                <input type ="submit" name = "serchoff" value = "検索解除"><br>
        </form>

            <hr><div class = "title">質問一覧</div><hr>
                <?php
                if(isset($serch)){
                    if(isset($subject2) && isset($solved)){
                        $sql = "SELECT * FROM m6_query WHERE groupid=0 AND subject='$subject2' AND solve=$solved AND userid!='$s_id' order by id desc";
                        $stmt = $pdo->query($sql);
                    }elseif(isset($subject2)){
                        $sql = "SELECT * FROM m6_query WHERE groupid=0 AND subject='$subject2' AND userid!='$s_id' order by id desc";
                        $stmt = $pdo->query($sql);
                    }elseif(isset($solved)){
                        $sql = "SELECT * FROM m6_query WHERE groupid=0 AND solve='$solved' AND userid!='$s_id' order by id desc";
                        $stmt = $pdo->query($sql);
                    }else{
                        $sql = "SELECT * FROM m6_query WHERE groupid=0 AND userid!='$s_id' order by id desc";
                        $stmt = $pdo->query($sql);
                    }
                }else{
                    $sql = "SELECT * FROM m6_query WHERE groupid=0 AND userid!='$s_id' order by id desc";
                    $stmt = $pdo->query($sql);
                }
                $row_count = $stmt -> rowCount();
                if($row_count == 0){
                    echo "検索結果に一致するものはありません";
                }else{
                    $results = $stmt->fetchAll();
                    foreach ($results as $row){
                        $query_row_id = $row['id'];
                        if(isset($serch) or isset($question2) or isset($serchoff)){
                            if(preg_match($unit2_2,$row['unit'])){
                                //アイコン表示
                                $userid = $row['userid'];
                                $sql = "SELECT * FROM m6_login WHERE id=$userid";
                                    $stmt = $pdo->query($sql);
                                    $result2s = $stmt->fetchAll();
                                    foreach ($result2s as $row2){
                                        $row_file_0 = $row2["filenum"];
                                        if($row2['filenum'] != 0){
                                            $sql = "SELECT * FROM m6_file WHERE id2='$row_file_0'";
                                            $stmt = $pdo->query($sql);
                                        }else{
                                            $sql = "SELECT * FROM m6_file WHERE id2=63";
                                            $stmt = $pdo->query($sql);
                                        }
                                        $result3s = $stmt->fetchAll();
                                        foreach ($result3s as $row3){
                            ?>
                                            <div class="file_icon">
                                                <img src="images/<?php echo $row3['filename'] ; ?>" width="30" height="30">   
                                            </div>               
                        <?php
                                        }
                                    }

                                //名前表示
                                if($row['noname'] == "1"){?>
                                    <span class = "name"><?php echo "匿名さん　";?></span><?php
                                }else{
                                    $userid = $row['userid'];
                                    $sql = "SELECT * FROM m6_login WHERE id=$userid";
                                        $stmt = $pdo->query($sql);
                                        $result2s = $stmt->fetchAll();
                                        foreach ($result2s as $row3){?>
                                            <span class = "name"><?php echo $row3['name']."　";?></span>
                                            <span class = "time"><?php echo $row3['userid']."　";?></span>
                        <?php            }
                                }
                        ?>                        
                                <!--時間表示、教科名、単元名、優良解答、質問内容表示-->
                                <span class = "time"><?php echo $row['time'];?></span>
                        <?php
                                if($row["solve"] == 1){?>
                                    <span class = "good"><?php echo "　済<br>";?></span>
                        <?php
                                }else{echo "<br>";}
                                echo "【".$row["subject"]."】　".$row['unit']."<br>".$row["question"]."<br>";
                        ?>
                        
                                <!--画像表示-->
                                <?php if($row['filename'] != "noimage") : ?>
                                    <a href="images/<?php echo $row['filename'] ; ?>" data-lightbox="<?php echo $row['filename'] ; ?>"><img src="images/<?php echo $row['filename'] ; ?>" width="300" height="300"></a>
                                <?php endif ; ?>
                                                            
                                <!--解説-->
                                <form target="_blank" action = "https://tb-220294.tech-base.net/mission6_main_solve.php" method = "post">
                                <div class="hidden_box">
                                    <input type = "hidden" name = "query_id" value = "<?php echo $row['id']?>">
                                    <input type = "submit" value = "解答する" style = "font-size:15px; border:solid 1px black;">
                                
                                <?php if($row["solve"] ==1) :?>
                                <!--優秀解答-->
                                    <label for="<?php echo 'label'.$row['id'];?>">優秀解答</label>
                                    <input type="checkbox" id="<?php echo 'label'.$row['id'];?>" style = "display:none"/> 
                                    <div class="hidden_show">
                                        <!--非表示ここから-->
                                    <h3>『優良解答』</h3>
                                    <?php
                                       $sql = "SELECT * FROM m6_answer WHERE qid='$query_row_id' AND good=2 order by id desc";
                                           $stmt = $pdo->query($sql);
                                           $result2s = $stmt->fetchAll();
                                           foreach ($result2s as $row3){
                                               //アイコン表示
                                               $row3_aid = $row3['aid'];
                                               $sql = "SELECT * FROM m6_login WHERE id='$row3_aid'";
                                               $stmt = $pdo->query($sql);
                                               $result3s = $stmt->fetchAll();
                                               foreach ($result3s as $row4){
                                                    $row_file_0 = $row4["filenum"];
                                                    if($row4['filenum'] == "0"){
                                                        $sql = "SELECT * FROM m6_file WHERE id2=63";
                                                        $stmt = $pdo->query($sql);
                                                    }else{
                                                        $sql = "SELECT * FROM m6_file WHERE id2='$row_file_0'";
                                                        $stmt = $pdo->query($sql);
                                                    }
                                                    $result4s = $stmt->fetchAll();
                                                    foreach ($result4s as $row5){
                        ?>                               
                                                        <div class="file_icon">
                                                            <img src="images/<?php echo $row5['filename'] ; ?>" width="30" height="30">   
                                                        </div>  
                        <?php
                                                    }
                                                }

                                                //名前表示
                                                $userid2 = $row3["aid"];
                                                $sql = "SELECT * FROM m6_login WHERE id=$userid2";
                                                $stmt = $pdo->query($sql);
                                                $result3s = $stmt->fetchAll();
                                                foreach ($result3s as $row4){?>
                                                    <span class = "name"><?php echo $row4['name']."　";?></span>
                                                    <span class = "time"><?php echo $row4['userid']."　";?></span>
                                    <?php           
                                                }       
                                    ?>                        
                                            <!--時間表示、解答内容表示-->
                                            <span class = "time"><?php echo $row3['time']."<br>";?></span>
                                    <?php
                                            echo $row3["answer"]."<br>";
                                    ?>                        
                                            <!--画像表示-->
                                            <?php if($row3['filename'] != "noimage") : ?>
                                                <a href="images/<?php echo $row3['filename'] ; ?>" data-lightbox="<?php echo $row3['filename'] ; ?>"><img src="images/<?php echo $row3['filename'] ; ?>" width="300" height="300"></a>
                                            <?php endif ; ?>
                                            <hr>
                                    <?php
                                           }
                                    ?>
                                        <!--ここまで-->
                                    </div>
                                <?php endif ; ?>
                                </div>
                                </form>  
                                <hr>
                    <?php   }                       
                        }
                    ;}
                }         ?>

<!--=========================質問するページ=========================-->
    <?php elseif(isset($question) or isset($send) or isset($moreq)) : ?>
        <?php if($go == NULL) : ?>
            <form action = "" method = "post" enctype = "multipart/form-data">
                <hr><div class = "title">教科名（必須）</div><hr>
                    <div class = "error"><?php echo $miss1; echo "　"; ?></div>
                    <label><input type = "radio" name = "subject" value = "国語" <?php if($subject == "国語"){echo "checked";} ?>>国語</label>
                    <label><input type = "radio" name = "subject" value = "算数" <?php if($subject == "算数"){echo "checked";} ?>>算数</label>
                    <label><input type = "radio" name = "subject" value = "数学" <?php if($subject == "数学"){echo "checked";} ?>>数学</label>
                    <label><input type = "radio" name = "subject" value = "英語" <?php if($subject == "英語"){echo "checked";} ?>>英語</label>
                    <label><input type = "radio" name = "subject" value = "理科" <?php if($subject == "理科"){echo "checked";} ?>>理科</label>
                    <label><input type = "radio" name = "subject" value = "社会" <?php if($subject == "社会"){echo "checked";} ?>>社会</label>
                    <label><input type = "radio" name = "subject" value = "その他" <?php if($subject == "その他"){echo "checked";} ?>>その他</label><br><br><hr>

                <div class = "title">単元範囲（必須）</div><hr>
                    <div class = "error"><?php echo $miss2; echo "　"; ?></div>
                    <input type = "text" name = "unit" placeholder = "現代文、三角関数、英作文..." style = "width:300px;" value = "<?php echo $unit;?>"><br><br><hr>
    
                <div class = "title">質問内容（必須）</div><hr>
                    <div class = "error"><?php echo $miss3; ?></div>
                    <textarea name = "q" rows = "8" cols = "60"><?php echo $q;?></textarea><br><hr>

                <div class = "title">問題の画像（任意）</div><hr>
                    <div class = "error"><?php echo $miss4; echo "　";?></div>
                    <input type = "file" name = "file" accept = "image/*"><br><br><hr>

                内容を確認し、よろしければ送信ボタンを押して下さい<br>
                    <input type = "submit" name = "send" value = "送信" style = "width:80px;">　
                    <label><input type = "checkbox" name = "noname" value = "1" <?php if(isset($send)){if($noname == 1){echo "checked";}} ?>>匿名で質問する<br><hr></label>
            </form>

        <?php elseif(isset($send) && $go != NULL) : ?>
            <h2>質問の送信が完了しました！</h2><br>
            <form action = "" method = post>
                <input type = "submit" name = "moreq" value = "もっと質問をする" style = "width:200px; height:30px; font-size:15px;">
            </form>
        <?php endif ; ?>


<!--==========================解答結果ページ==========================-->
    <?php elseif(isset($answer) or isset($serch2) or isset($serchoff2) or isset($change)) : ?>
        <form action = "" method = "post" enctype = "multipart/form-data">
            <hr><div class = "title">条件で絞る</div><hr>
            ＊教科：
                <label><input type = "radio" name = "subject3" value = "国語" <?php if(isset($serch2) && $subject3 == "国語"){echo "checked";}?>>国語</label>
                <label><input type = "radio" name = "subject3" value = "算数" <?php if(isset($serch2) && $subject3 == "算数"){echo "checked";}?>>算数</label>
                <label><input type = "radio" name = "subject3" value = "数学" <?php if(isset($serch2) && $subject3 == "数学"){echo "checked";}?>>数学</label>
                <label><input type = "radio" name = "subject3" value = "英語" <?php if(isset($serch2) && $subject3 == "英語"){echo "checked";}?>>英語</label>
                <label><input type = "radio" name = "subject3" value = "理科" <?php if(isset($serch2) && $subject3 == "理科"){echo "checked";}?>>理科</label>
                <label><input type = "radio" name = "subject3" value = "社会" <?php if(isset($serch2) && $subject3 == "社会"){echo "checked";}?>>社会</label>
                <label><input type = "radio" name = "subject3" value = "その他" <?php if(isset($serch2) && $subject3 == "その他"){echo "checked";}?>>その他</label><br>
            ＊単元：
                <input type = "text" name = "unit3" placeholder = "現代文、三角関数、英作文..." style = "width:300px;" value = "<?php if(isset($serch2)){echo $unit3;}?>"><br>
            ＊解決：
                <label><input type = "radio" name = "solved2" value = "1" <?php if(isset($serch2) && $solved2 == '1'){echo "checked";}?>>解決済み</label>
                <label><input type = "radio" name = "solved2" value = "0" <?php if(isset($serch2) && $solved2 == '0'){echo "checked";}?>>未解決</label><br>
                <input type = "submit" name = "serch2" value = "🔎検索">　
                <input type = "submit" name = "serchoff2" value = "検索解除">
                
        </form>

                <hr><div class = "title">質問一覧</div><hr>
                <?php
                if(isset($serch2)){
                    if(isset($subject3) && isset($solved2)){
                        $sql = "SELECT * FROM m6_query WHERE groupid=0 AND subject='$subject3' AND solve=$solved2 AND userid='$s_id' order by id desc";
                        $stmt = $pdo->query($sql);
                    }elseif(isset($subject2)){
                        $sql = "SELECT * FROM m6_query WHERE groupid=0 AND subject='$subject3' AND userid='$s_id' order by id desc";
                        $stmt = $pdo->query($sql);
                    }elseif(isset($solved2)){
                        $sql = "SELECT * FROM m6_query WHERE groupid=0 AND solve='$solved2' AND userid='$s_id' order by id desc";
                        $stmt = $pdo->query($sql);
                    }else{
                        $sql = "SELECT * FROM m6_query WHERE groupid=0 AND userid='$s_id' order by id desc";
                        $stmt = $pdo->query($sql);
                    }
                }else{
                    $sql = "SELECT * FROM m6_query WHERE groupid=0 AND userid='$s_id' order by id desc";
                    $stmt = $pdo->query($sql);
                }
                $row_count = $stmt -> rowCount();
                if($row_count == 0 && isset($serch2)){
                    echo "検索結果に一致するものはありません";
                }elseif($row_count == 0 && !isset($serch2)){
                    echo "自分の質問が出ます";
                }else{
                    $results = $stmt->fetchAll();
                    foreach ($results as $row){
                        if(isset($serch2) or isset($answer) or isset($serchoff2)){
                            if(preg_match($unit3_2,$row['unit'])){?>
                                                
                                <!--時間表示、教科名、単元名、優良解答、質問内容表示-->
                                <span class = "time"><?php echo $row['time'];?></span>
                        <?php
                                if($row["solve"] == 1){?>
                                    <span class = "good"><?php echo "　済<br>";?></span>
                        <?php
                                }else{echo "<br>";}

                                echo "【".$row["subject"]."】　".$row['unit']."<br>".$row["question"]."<br>";
                        ?>
                        
                                <!--画像表示-->
                                <?php if($row['filename'] != "noimage") : ?>
                                    <a href="images/<?php echo $row['filename'] ; ?>" data-lightbox="<?php echo $row['filename'] ; ?>"><img src="images/<?php echo $row['filename'] ; ?>" width="300" height="300"></a>
                                <?php endif ; ?>

                                <br>
                        <?php
                            $row_id = $row["id"];
                            $sql = "SELECT * FROM m6_answer WHERE qid='$row_id' AND readed=0";
                            $stmt = $pdo->query($sql);
                            $row_count_read = $stmt -> rowCount();
                        ?>

                                <div style="display:inline-flex">
                                <form target="_blank" action = "https://tb-220294.tech-base.net/mission6_main_editQ.php" method = "post">
                                    <input type = "submit" value = "編集" style = "width:100px; height:30px; font-size:15px;">　
                                    <input type = "hidden" name = "qnum" value = "<?php echo $row['id']; ?>">
                                </form>
                                <form target="_blank" action = "https://tb-220294.tech-base.net/mission6_main_answer.php" method = "post">
                                    <input type = "submit" name = "toanswer" value = "解説" style = "width:100px; height:30px; font-size:15px;">
                                    <span style = "color:red"><?php if($row_count_read != 0){echo $row_count_read;}?></span>
                                    <input type = "hidden" name = "qnum" value = "<?php echo $row['id']; ?>">
                                </form>　
                                </div>
                                <hr>               
                                
                    <?php   }                       
                        }
                    ;}
                }     ?>
        
<!--==========================グループページ==========================-->
    <?php elseif(isset($group) || isset($grouptomain)) : ?>

    <?php
        $sql = "SELECT * FROM m6_group_user WHERE username='$s_id'";
        $stmt = $pdo->query($sql);
        $row_count = $stmt -> rowCount();
        if($row_count == 0){
            echo "参加しているグループはありません";
        }else{
            $result0s = $stmt->fetchAll();
            foreach ($result0s as $row0){
                $row_groupid = $row0["groupid"];
                $sql = "SELECT * FROM m6_group WHERE id='$row_groupid'";
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    $row_id = $row["id"];
                    echo "＊".$row["groupname"]."　";
        
    ?>
            <form action = "" method = "post">                
                <div class="hidden_box">
                    <input type = "hidden" name = "groupid" value = "<?php echo $row_id?>">
                    <input type = "submit" name = "togroup" value = "ひらく" style = "font-size:15px; border:solid 1px black;">　
                    <label for="<?php echo 'label'.$row_id;?>">参加者</label>
                        <input type="checkbox" id="<?php echo 'label'.$row_id;?>" style = "display:none"/> 
                        <div class="hidden_show">
                            <!--非表示ここから-->
    <?php
                            $sql = "SELECT * FROM m6_group_user WHERE groupid='$row_id'";
                            $stmt = $pdo->query($sql);
                            $result2s = $stmt->fetchAll();
                            foreach ($result2s as $row2){
                                $row2_username = $row2["username"];
                    
                                $sql = "SELECT * FROM m6_login WHERE id='$row2_username'";
                                $stmt = $pdo->query($sql);
                                $result3s = $stmt->fetchAll();
                                foreach ($result3s as $row3){
                                    //アイコン表示
                                    $row_file_0 = $row3["filenum"];
                       
                                    if($row3['filenum'] == 0){
                                        $sql = "SELECT * FROM m6_file WHERE id2=63";
                                        $stmt = $pdo->query($sql);
                                    }else{
                                        $sql = "SELECT * FROM m6_file WHERE id2='$row_file_0'";
                                        $stmt = $pdo->query($sql);
                                    }
                                    $result4s = $stmt->fetchAll();
                                    foreach($result4s as $row4){
    ?>                               
                                        <div class="file_icon">
                                            <img src="images/<?php echo $row4['filename'] ; ?>" width="30" height="30">   
                                        </div>  
    <?php
                                    }
                                    //名前表示
                                    echo "名前：".$row3["name"]."、ID：".$row3["userid"]."<br>";
                                }
                            }                           
    ?>                       
                            <!--ここまで-->
                        </div>
                </div>
            </form>
                <hr>
    <?php
                }
            }
        }
    ?>

    

<!--==========================設定ページ===========================-->    
    <?php elseif(isset($setting) || isset($passtomain) || isset($editlogtomain) || isset($mailtomain) || isset($updatetomain)) : ?>
        <hr><div class = "title">ユーザー情報</div><hr>

        <?php
            $sql = "SELECT * FROM m6_login WHERE id='$s_id'";
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                    foreach ($results as $row){
                        $row_file_1 = $row["filenum"]+1
        ?>
                        <!--アイコン表示-->
                        <?php if($row['filenum'] == 0) : ?>
        <?php
                            $sql = "SELECT * FROM m6_file WHERE id=61";
                                $stmt = $pdo->query($sql);
                                $result2s = $stmt->fetchAll();
                                    foreach ($result2s as $row2){
        ?>                               
                                        <style>
                                        .user_nofile{
                                            background-image: url("images/<?php echo $row2['filename'] ; ?>");
                                            width:  300px;
                                            height: 300px;
                                            border-radius: 50%;
                                            background-position: center center;
                                            border: 1px solid black;
                                        }
                                        </style>                                        
                                        <div class="user_nofile">
                                            <!--画像表示範囲-->
                                        </div>
        <?php
                                    }
        ?>
                        <?php else : ?>                               
        <?php
                            $sql = "SELECT * FROM m6_file WHERE id='$row_file_1'";
                                $stmt = $pdo->query($sql);
                                $result2s = $stmt->fetchAll();
                                    foreach ($result2s as $row2){
        ?>                               
                                        <style>
                                        .user_file{
                                            background-image: url("images/<?php echo $row2['filename'] ; ?>");
                                            width:  300px;
                                            height: 300px;
                                            border-radius: 50%;
                                            background-position: center center;
                                            border: 1px solid black;
                                        }
                                        </style>                                        
                                        <div class="user_file">
                                            <!--画像表示範囲-->
                                        </div>
        <?php
                                    }
        ?>
                        <?php endif ; ?>

                        <br>
                        <!--ユーザーID、名前-->
        <?php
                        echo "・ユーザーID：".$row["userid"]."<br>・名前：".$row["name"]."<br><br>";
        ?>
        <div style="display:inline-flex">
            <form action = "https://tb-220294.tech-base.net/mission6_main_editlogin.php" method = "post">
                <input type = "submit" name = "editlogin" value = "編集する" style = "width:200px; height:30px; font-size:15px;">　
            </form>
            <form action = "" method = "post">
                <input type = "button" name = "logout" value = "ログアウト" onClick="kakunin()" style = "width:200px; height:30px; font-size:15px;"><br>
            </form>
        </div>
        <script language="javascript" type="text/javascript">
            function kakunin(){
                ret = confirm("本当にログアウトしますか？");
                if (ret == true){
                    location.href = "https://tb-220294.tech-base.net/mission6_logout.php";
                }
            }
        </script>

        <?php
                    }
        ?>

        <hr><div class = "title">セキュリティー</div><hr>
        <br>
        <div style="display:inline-flex">
            <form action = "https://tb-220294.tech-base.net/mission6_main_mail.php" method = "post">
                <input type = "submit" name = "editloginmail" value = "メールアドレスを変更する" style = "width:200px; height:30px; font-size:15px;">
            </form>　
            <form action = "https://tb-220294.tech-base.net/mission6_main_pass.php" method = "post">
                <input type = "submit" name = "editloginpass" value = "パスワードを変更する" style = "width:200px; height:30px; font-size:15px;"><br>
            </form>
        </div>
        <br><br>

        <hr><div class = "title">その他情報</div><hr>
    
    <?php
        $sql = "SELECT * FROM m6_reply WHERE anum='$s_id' AND qnum!='$s_id' AND readed=0";
        $stmt = $pdo->query($sql);
        $row_count_read2 = $stmt -> rowCount();
    ?>

        ・質問数：<?php echo $row_countQ; ?><br><br>
        ・解答数：<?php echo $row_countA; ?>
        <div style="display:inline-flex">　
            <form target="_blank" action = "https://tb-220294.tech-base.net/mission6_main_reply_check.php" method = "post">
                <button class = "replycheck" type = "submit" name = "replycheck">✉️　<span style="color:red"><?php if($row_count_read2 != 0){echo $row_count_read2;} ?></span></button>
            </form>　
        </div>
        <br><br>
        ・優秀解答数：<?php echo $row_countSA; ?><br><br>
        ・アカウント更新日：<?php echo $_SESSION["updated_at"]; ?><br><br>
        ・アカウント作成日：<?php echo $_SESSION["created_at"]; ?><br><br><br>

    <?php elseif(isset($editlogin)) : ?>
    ユーザー情報を編集するページ

    <?php elseif(isset($editloginmail)) : ?>
    メールアドレスを編集するページ

    <?php elseif(isset($editloginpass)) : ?>
    パスワードを編集するページ

<!--===========================ホーム画面========================-->
    <?php else : ?>
    <div class = "home">
    <br>
        <div class="balloon">
            <h3>　　今日は何しよう？？　　<br>　 右の機能から選んでね　</h3>
        </div><br>
    <?php
        $session_filenum = $_SESSION["filenum"]+4;
        if($session_filenum != 4){
            $sql = "SELECT * FROM m6_file WHERE id='$session_filenum'";
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
    ?>
                    <img src="images/<?php echo $row['filename'] ; ?>" style="width:400px;height:400px;">
    <?php       }  
        }else{
            $sql = "SELECT * FROM m6_file WHERE id=64";
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
    ?>
                    <img src="images/<?php echo $row['filename'] ; ?>" style="width:400px;height:400px;">
    <?php       }
        }
    ?>
    <br><br><br><br><br><br><br><br><br>

    </div>

    <?php endif ; ?>

    </div>

<!--=================================ユーザー情報（サブページ）=================================-->
    <div class = "sub">
        <hr><span style = "text-align:center"><h3>ユーザー情報</h3><hr>

    <?php
        if($_SESSION['userid'] != NULL){
            $sql = 'SELECT * FROM m6_login';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row2){
                $row_file_0 = $row2["filenum"];
                if($row2["userid"] == $_SESSION["userid"]){
                    if($row_file_0 == 0){
                        $sql = 'SELECT * FROM m6_file WHERE id=62';
                        $stmt = $pdo->query($sql);
                        $result2s = $stmt->fetchAll();
                        foreach ($result2s as $row3){?>
                            <div class = "userfile">
                            <img src="images/<?php echo $row3['filename'] ; ?>" width="300px" height="80px">
                            </div><?php
                        }
                    }else{
                        $sql = "SELECT * FROM m6_file WHERE id='$row_file_0'";
                        $stmt = $pdo->query($sql);
                        $result2s = $stmt->fetchAll();
                        foreach ($result2s as $row3){?>
                            <Marquee scrollamount="10" truespeed behavior="scroll" bgcolor="#CCFFCC">
	                            <img src="images/<?php echo $row3['filename'] ; ?>" style="width:80px;height:80px;">
                            </Marquee>
    <?php
                        }
                    }
                    echo "<br>お名前：".$_SESSION["name"]."<br>";
                    echo "My ID：".$_SESSION["userid"]."<br><hr>";
                }
            }
        }
    ?>
        <h3>機能</h3><hr>
        <form action = "" method = "post">
            <input type = "submit" name = "question2" value = "質問一覧" style = "<?php if(isset($question2) or isset($serch) or isset($solve) or isset($serchoff) or isset($goback) or isset($goback2)){echo "border:2px solid red; height:40px; width:250px; font-size:20px;";}else{echo "width:200px; height:30px; font-size:15px;";} ?>"><br><br>
            <input type = "submit" name = "question" value = "質問する" style = "<?php if(isset($question) or isset($send) or isset($moreq)){echo "border:2px solid red; height:40px; width:250px; font-size:20px;";}else{echo "width:200px; height:30px; font-size:15px;";} ?>"><br><br>
            <input type = "submit" name = "answer" value = "解答結果" style = "<?php if(isset($answer) or isset($serch2) or isset($serchoff2)){echo "border:2px solid red; height:40px; width:250px; font-size:20px;";}else{echo "width:200px; height:30px; font-size:15px;";} ?>"><br><br>
            <input type = "submit" name = "group" value = "グループ" style = "<?php if(isset($group) || isset($grouptomain)){echo "border:2px solid red; height:40px; width:250px; font-size:20px;";}else{echo "width:200px; height:30px; font-size:15px;";}?>"><br><br>
            <input type = "submit" name = "setting" value = "設定" style = "<?php if(isset($setting) || isset($passtomain) || isset($editlogtomain) || isset($mailtomain) || isset($updatetomain)){echo "border:2px solid red; height:40px; width:250px; font-size:20px;";}else{echo "width:200px; height:30px; font-size:15px;";} ?>"><br>
        </form>
        </span>
    </div>
</body>
</html>