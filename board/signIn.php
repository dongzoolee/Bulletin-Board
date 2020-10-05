<?php
    header("Content-Type:text/html;charset=utf-8");
    include "./session.php";
    include "../dbConnect.php";
    $id=$_POST['id'];
    $pw=md5($pw=$_POST['pw']);
    $sql="SELECT*FROM never_join WHERE id='$id' AND pw='$pw'";
    $res = $mysqli->query($sql);
    $row=$res->fetch_array(MYSQLI_ASSOC);
    // 위처럼 하면, 넘어온 결과를 한 행씩 패치해서
    // $row 라는 배열에 담아낼 수 있습니다.
    if($row!=null){
        $aa = $row['name'];
        $_SESSION['name']=$aa;
        $_SESSION['userid']=$aa;
        echo "<script>alert('$aa'+'님 안녕하세요');
        location.href='../leed.php';</script>";
        //echo "window.location.replace('./leed.html')</script>";
    }else{
        echo "<script>alert('아이디 혹은 비밀번호가 잘못되었습니다.');
        history.back();</script>";
        
        //echo "window.location.replace('./login.html')</script>";
    }
?>