<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>SHARE BRAINS|解答ページ</title>
    <style>
    .q{
        float: left;
        width: 50%;
    }
    .a{
        float: right;
        width: 49%;
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
    .file_icon {
        vertical-align: middle ;
        display: inline-block;
    }
    </style>
    <script language="javascript" type="text/javascript">
        function checkA() {
            const a = document.getElementById("a");
            const send = document.getElementById("send");
            if(a.value && a.value.length) {
                send.disabled = false;
            } else {
                send.disabled = true;
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js" type="text/javascript"></script>
</head>
<body>
<?php
    session_start();
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
    $user = 'tb-220294';
    $password = 'DwHvwN6WH6';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    $query_id = $_POST["query_id"];;
    $s_id = $_SESSION["id"];
    $a = $_POST["a"];
    $file_name = $_FILES["file"]["name"];
    $file_tmp = $_FILES['file']['tmp_name'];
    $image = uniqid(mt_rand(), true);//ファイル名をユニーク化
    $image .= '.' . substr(strrchr($file_name, '.'), 1);//アップロードされたファイルの拡張子を取得
    $noimage = "noimage";
    $send = $_POST["send"];
    $go = NULL;

    $sql = "SELECT * FROM m6_answer WHERE qid='$query_id'";
    $stmt = $pdo->query($sql);
    $result2s = $stmt->fetchAll();
    foreach ($result2s as $row2){
        if($s_id == $row2['aid']){
            $miss = "※以前に解答した質問です";
        }
    }   

    if(isset($send)){ 
        if($query_id != NULL){                
            $go = "質問送信";
            $sql = $pdo -> prepare("INSERT INTO m6_answer (qid, aid, answer, filename, time, good, readed) VALUES (:qid, :aid, :answer, :filename, now(), 1,0)");
                $sql -> bindParam(':qid', $query_id, PDO::PARAM_INT); 
                $sql -> bindParam(':aid', $s_id, PDO::PARAM_INT); 
                $sql -> bindParam(':answer', $a, PDO::PARAM_STR);
                if(!empty($file_name)){
                    $sql -> bindParam(':filename', $image, PDO::PARAM_STR);
                    move_uploaded_file($file_tmp,'./images/'.$image);//imagesディレクトリにファイル保存
                }else{
                    $sql -> bindParam(':filename', $noimage, PDO::PARAM_STR);
                }
                $sql -> execute();
        }else{
            ?>
            <script language="javascript" type="text/javascript">
                alert('質問を選択して下さい');
                location.href = "https://tb-220294.tech-base.net/mission6_login.php";
            </script>
            <?php
        }
    }  
?>

<?php if($go != NULL) : ?>
    <h1>解答を送信しました！</h1>
  
<?php else : ?>
<div class = "q">
    <hr><div class = "title">質問</div><hr>
        <?php
            $sql = "SELECT * FROM m6_query WHERE id='$query_id'";
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){ 
                //アイコン表示
                $userid = $row['userid'];
                $sql = "SELECT * FROM m6_login WHERE id=$userid";
                    $stmt = $pdo->query($sql);
                    $result2s = $stmt->fetchAll();
                    foreach ($result2s as $row2){
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
                    }

                //名前表示
                if($row['noname'] == "1"){?>
                    <span class = "name"><?php echo "匿名さん　";?></span><?php
                }else{
                    $userid = $row['userid'];
                    $sql = "SELECT * FROM m6_login WHERE id='$userid'";
                        $stmt = $pdo->query($sql);
                        $result2s = $stmt->fetchAll();
                        foreach ($result2s as $row3){?>
                            <span class = "name"><?php echo $row3['name']."　";?></span>
                            <span class = "time"><?php echo $row3['userid']."　";?></span>
        <?php            }
                }
        ?>                        
                <!--時間表示、教科名、単元名、質問内容表示-->
                <span class = "time"><?php echo $row['time']."<br>";?></span><?php
                echo "【".$row["subject"]."】　".$row['unit']."<br>".$row["question"]."<br>"; ?>
                        
                <!--画像表示-->
                <?php if($row['filename'] != "noimage") : ?>
                    <a href="images/<?php echo $row['filename'] ; ?>" data-lightbox="group"><img src="images/<?php echo $row['filename'] ; ?>" width="99%" height="500"></a>
                <?php endif ; ?>                                                                             
    <?php   ;}     ?><hr>
</div>

<div class = "a">
    <div class = "error"><?php echo $miss ?></div>
    <hr><div class = "title">解説</div><hr>
        <form action = "" method = "post" enctype = "multipart/form-data">
            <h3>●解説入力（必須）</h3>
                <textarea name = "a" id = "a" rows = "8" cols = "60" oninput="checkA()"><?php if($go == NULL){echo $a;}?></textarea><br><hr>

            <h3>●解説画像（任意）</h3>
                <input type = "file" name = "file" accept = "image/*"><br><br><hr>

            内容を確認し、よろしければ送信ボタンを押して下さい<br>
                <input type = "hidden" name = "query_id" value = "<?php echo $query_id?>">
                <button type = "submit" id = "send" name = "send" style = "width:80px;" disabled>送信</button><br>
        </form>
</div>

<?php endif ; ?>
</body>
</html>