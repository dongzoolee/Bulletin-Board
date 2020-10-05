<?php
    header("Content-Type:text/html;charset=utf-8");
    include "../dbInfo/dbConnect.php";
    include '../session/session.php';
    $name=$_SESSION['name'];
    $title=$_POST['title'];
    $content=$_POST['content'];
    $date = date("Y-m-d", time());
    $unq_num=$_SESSION['unq_num'];
    $sql="INSERT INTO bullitin(title,name,date,content,unq_num,hit)
    VALUES('$title','$name','$date','$content','$unq_num','0');";
    $res=$mysqli->query($sql);
    if($res){
        echo "<script>alert('게시 완료');
        location.href='./leedBoard.php';</script>";
    }else{
        echo "<script>alert('게시 실패');
        history.back();</script>";
    }
?>