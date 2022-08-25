<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>投稿掲示板</title>
</head>
<body>
   
    <?php
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    
     $sql = "CREATE TABLE IF NOT EXISTS 掲示板"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "time char(20),"
    . "suitti char(1),"
    . "pas char(20)"
    .");";
    $stmt = $pdo->query($sql);


    
    session_start();
    $comment0 = $_POST["comment"];
    $name0 = $_POST["name"];
    $num = $_POST["num"];
    $time = date("Y/m/d H:i:s");
    $num2 = $_POST["num2"];
    $sui = 0;
    $num3 = $_POST["tt"];
    $pas0 = $_POST["pas"];
    $pas2 = $_POST["pas2"];
    
        //【！この SQLは tbtest テーブルを削除します！】
       /* $sql = 'DROP TABLE 掲示板';
        $stmt = $pdo->query($sql);
        */
           

    
     if(empty($comment0)!=true&&empty($name0)!=true&&empty($pas0)!=true&&empty($num3)==true){ 
     
            
    //m4-5
        $sql = $pdo -> prepare("INSERT INTO 掲示板 (name, comment, time, suitti, pas) VALUES (:name, :comment, :time, :suitti, :pas)");
        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql -> bindParam(':time', $time, PDO::PARAM_STR);
        $sql -> bindParam(':suitti', $suitti, PDO::PARAM_STR);
        $sql -> bindParam(':pas', $pas, PDO::PARAM_STR);
        $name = $name0;
        $comment = $comment0 ; 
        $pas = $pas0;
        $suitti = 0;
    //好きな名前、好きな言葉は自分で決めること
        $sql -> execute();
    //bindParamの引数名（:name など）はテーブルのカラム名に併せるとミスが少なくなります。最適なものを適宜決めよう。
            
    

            
     }elseif(empty($num)!=true){  
    

        $sql = 'SELECT * FROM 掲示板';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
            if($row[0]==$num){
            $pas3 = $row['pas'];
            "<hr>";
     
        }

    }
    
    
    if($pas3==$pas2){
            //m4-8
        $id = $num;
        $sql = 'delete from 掲示板 where id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $suitti = 0;
        }else{
            echo "パスワードが違うんだぜ＞_＜";
        }
      
     }elseif(empty($num2)!=true){

        $sql = 'SELECT * FROM 掲示板';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
            if($row[0]==$num2){
            $pas3 = $row['pas'];
            "<hr>";
     
        }

    }
    
    
    if($pas3==$pas2){
        $sui = 1;
        $sql = 'SELECT * FROM 掲示板';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
            if($row[0]==$num2){
            
                $sui2 = $row['id'];
                $name2 = $row['name'];
                $comment2 = $row['comment'];
                $pas00 = $row['pas'];
                "<hr>";
     
                }

        }
    
    }else{
        
        echo "パスワードが違うんだぜ＞_＜";
        
    }
         
         
         
     }elseif(empty($comment0)!=true&&empty($name0)!=true&&empty($pas0)!=true&&empty($num3)!=true){
       
          //m4-7 
        //bindParamの引数（:nameなど）は4-2でどんな名前のカラムを設定したかで変える必要がある。
        $id = $num3; //変更する投稿番号
        $name = $name0;
        $comment = $comment0; 
        $pas = $pas0;
        $taime = date("Y/m/d H:i:s");
 
    //変更したい名前、変更したいコメントは自分で決めること
        $sql = 'UPDATE 掲示板 SET name=:name,comment=:comment,time=:time,pas=:pas WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':time', $time, PDO::PARAM_STR);
        $stmt->bindParam(':pas', $pas, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
    
    
     } else{
          echo "必須項目が未記入です<br>";

     }
     
     
     
    ?>
    
     <form action="" method="post">
        <p>お名前:<input type="txet" name="name" value = <?php if($sui == 1){echo $name2; }?>></p>
        <p>コメント</p>
       <p></p><textarea name="comment" cols="40"　 rows = "5" placeholder = "コメント"><?php if($sui==1){echo $comment2;} ?></textarea></p>
       <p>パスワードを設定してください<input tyep = "text" name = "pas" value = <?php if($sui==1){echo $pas00;} ?>></p>
       
       <p>削除したい行を入れてください<input type = "number" name = "num"></p>
       <p>編集したい行を選んでください<input type = "number" name = "num2"></p>
       <P>設定したパスワードを入れてください<input tyep = "text" name = "pas2"></P>
       
      
       <p><input type = "submit" value = "送信"></p>
       <input type = "hidden" name = "tt" value = <?php if($sui==1){ echo $sui2;}?>>
       
    </form>
    
    <?php

                 //m4-6
        //$rowの添字（[ ]内）は、4-2で作成したカラムの名称に併せる必要があります。
    $sql = 'SELECT * FROM 掲示板';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['time'].'<br>';
        
    echo "<hr>";
    }
    ?>
    
    
</body>
</html>