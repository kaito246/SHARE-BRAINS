<?php 
    session_start(); 
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>グループ｜SHARE BRAINS</title>

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
    .file_icon {
        vertical-align: middle ;
        display: inline-block;
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
    </style>

<script language="javascript" type="text/javascript">
    //トップへとぶボタンの作成-----------------
    jQuery(function() {
        var pagetop = $('#page_top');   
        pagetop.hide();
        $(window).scroll(function () {
            if($(this).scrollTop() > 200) {  //200pxスクロールしたら表示
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

<div id="page_top"><a href="#"></a></div>

<?php if(!isset($_SESSION["userid"])) : ?>
    <script language="javascript" type="text/javascript">
        alert('セッションが無効です');
        location.href = "https://tb-220294.tech-base.net/mission6_login.php";
    </script>
<?php endif ; ?>


<?php
    error_reporting(E_ALL & ~E_NOTICE); //Noticeを表示させない

    //DBに接続
    $dsn = 'mysql:dbname=***;host=***';
    $user = '***';
    $password = '***';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    $s_id = $_SESSION["id"];
    $s_groupid = $_SESSION["groupid"];

    $sql = "SELECT * FROM m6_group WHERE id='$s_groupid'";
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        $_SESSION["groupname"] = $row["groupname"];
        $s_groupname = $_SESSION["groupname"];
        $_SESSION["cr_time"] = $row["cr_time"];
        $s_cr_time = $_SESSION["cr_time"];
        $_SESSION["createname"] = $row["createname"];
        $s_createname = $_SESSION["createname"];
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
                $sql = $pdo -> prepare("INSERT INTO m6_query (userid, subject, unit, question, filename, time, solve, editfile, delatefile, groupid) VALUES (:userid, :subject, :unit, :question, :filename, now(), 0, 0, 0, :groupid)");
                    $sql -> bindParam(':userid', $_SESSION["id"], PDO::PARAM_INT); 
                    $sql -> bindParam(':subject', $subject, PDO::PARAM_STR);
                    $sql -> bindParam(':unit', $unit, PDO::PARAM_STR);
                    $sql -> bindParam(':question', $q, PDO::PARAM_STR);
                    if(!empty($file_name)){
                        $sql -> bindParam(':filename', $image, PDO::PARAM_STR);
                        move_uploaded_file($file_tmp,'./images/'.$image);//imagesディレクトリにファイル保存
                    }else{
                        $sql -> bindParam(':filename', $noimage, PDO::PARAM_STR);
                    }
                    $sql -> bindParam(':groupid', $s_groupid, PDO::PARAM_INT);
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

?>



<!--============================================メインページ=============================================-->

    <div class = "main">

<!--==========================質問一覧ページ=========================-->
    <?php if(isset($question2) or isset($serch) or isset($serchoff) or isset($talktogroup)) : ?>
    
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
                        $sql = "SELECT * FROM m6_query WHERE groupid='$s_groupid' AND subject='$subject2' AND solve=$solved order by id desc";
                        $stmt = $pdo->query($sql);
                    }elseif(isset($subject2)){
                        $sql = "SELECT * FROM m6_query WHERE groupid='$s_groupid' AND subject='$subject2' order by id desc";
                        $stmt = $pdo->query($sql);
                    }elseif(isset($solved)){
                        $sql = "SELECT * FROM m6_query WHERE groupid='$s_groupid' AND solve='$solved' order by id desc";
                        $stmt = $pdo->query($sql);
                    }else{
                        $sql = "SELECT * FROM m6_query WHERE groupid='$s_groupid' order by id desc";
                        $stmt = $pdo->query($sql);
                    }
                }else{
                    $sql = "SELECT * FROM m6_query WHERE groupid='$s_groupid' order by id desc";
                    $stmt = $pdo->query($sql);
                }
                $row_count = $stmt -> rowCount();
                if($row_count == 0 && isset($serch)){
                    echo "検索結果に一致するものはありません";
                }elseif($row_count == 0 && !isset($serch)){
                    echo "まだ質問はありません";
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
                                    $userid = $row['userid'];
                                    $sql = "SELECT * FROM m6_login WHERE id=$userid";
                                        $stmt = $pdo->query($sql);
                                        $result2s = $stmt->fetchAll();
                                        foreach ($result2s as $row3){?>
                                            <span class = "name"><?php echo $row3['name']."　";?></span>
                                            <span class = "time"><?php echo $row3['userid']."　";?></span>
                        <?php            
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
                                                    
                                
                                <!--コメント-->
                                <div class="hidden_box">
                                    <label for="<?php echo 'label'.$row['id'];?>">コメント</label>
                                    <input type="checkbox" id="<?php echo 'label'.$row['id'];?>" style = "display:none"/> 
                                    <div class="hidden_show">
                                        <!--非表示ここから-->
                                    <h3>『コメント』</h3>
                                    <?php
                                        $sql = "SELECT * FROM m6_group_talk WHERE qid='$query_row_id'";
                                        $stmt = $pdo->query($sql);
                                        $results = $stmt->fetchAll();
                                            foreach($results as $row){
                                                $cnum = $row["cnum"];
                                                $sql = "SELECT * FROM m6_login WHERE id='$cnum'";
                                                $stmt = $pdo->query($sql);
                                                $result2s = $stmt->fetchAll();
                                                foreach($result2s as $row2){
                                                    //アイコン表示
                                                    $row_file_0 = $row2["filenum"];
                                                    if($row2['filenum'] == "0"){
                                                        $sql = "SELECT * FROM m6_file WHERE id2=63";
                                                        $stmt = $pdo->query($sql);
                                                    }else{
                                                        $sql = "SELECT * FROM m6_file WHERE id2='$row_file_0'";
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
                                                        //名前表示
                        ?>
                                                        <span class = "name"><?php echo $row2['name']."　";?></span>
                                                        <span class = "time"><?php echo $row2['userid']."　";?></span>
                        <?php
                                                }
                        ?>                                            
                                                        <!--時間表示、コメント内容表示-->
                                                        <span class = "time"><?php echo $row['time']."<br>";?></span>
                                                        <?php echo $row['c']."<br>"; ?>
                        
                                                        <!--画像表示-->
                                                        <?php if($row['filename'] != "noimage") : ?>
                                                            <a href="images/<?php echo $row['filename'] ; ?>" data-lightbox="<?php echo $row['filename'] ; ?>"><img src="images/<?php echo $row['filename'] ; ?>" width="300" height="300"></a>
                                                        <?php endif ; ?>    
                                                        <hr>                                          
                        <?php       
                                            }
                        ?>
                                    <hr>
                                    <!--コメントする-->
                                        <form target="_blank" action = "https://tb-220294.tech-base.net/mission6_main_group_talk.php" method = "post">
                                            <input type = "hidden" name = "qid" value = "<?php echo $query_row_id?>">
                                            <input type = "submit" name = "gotalk" value = "コメントする" style = "font-size:15px; border:solid 1px black;">
                                        </form>
                                        <!--ここまで-->
                                    </div>
                                </div>  
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
                    <br><hr>
            </form>

        <?php elseif(isset($send) && $go != NULL) : ?>
            <h2>質問の送信が完了しました！</h2><br>
            <form action = "" method = post>
                <input type = "submit" name = "moreq" value = "もっと質問をする" style = "width:200px; height:30px; font-size:15px;">
            </form>
        <?php endif ; ?>

<!--===========================ホーム画面========================-->

<?php else : ?>
    <div class = "home">
    <br>
        <div class="balloon">
            <h3>　　グループへようこそ！　　<br>　 右の機能から選んでね　</h3>
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
    <br><br><br><br><br><br><br><br><br><br><br><br>

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
                    echo "My ID：".$_SESSION["userid"]."<br>";
                    echo "グループ：".$s_groupname."<br><hr>";
                }
            }
        }
    ?>
        <h3>機能</h3><hr>
        <form action = "" method = "post">
            <input type = "submit" name = "question2" value = "質問一覧" style = "<?php if(isset($question2) or isset($serch) or isset($solve) or isset($serchoff) or isset($goback) or isset($goback2) or isset($talktogroup)){echo "border:2px solid red; height:40px; width:250px; font-size:20px;";}else{echo "width:200px; height:30px; font-size:15px;";} ?>"><br><br>
            <input type = "submit" name = "question" value = "質問する" style = "<?php if(isset($question) or isset($send) or isset($moreq)){echo "border:2px solid red; height:40px; width:250px; font-size:20px;";}else{echo "width:200px; height:30px; font-size:15px;";} ?>"><br><br>
        </form>
        <form action = "https://tb-220294.tech-base.net/mission6_main2.php" method = "post">
            <input type = "submit" name = "grouptomain" value = "メインへ" style = "width:200px; height:30px; font-size:15px;"><br>
        </form>
        </span>
    </div>
    
</body>
</html>