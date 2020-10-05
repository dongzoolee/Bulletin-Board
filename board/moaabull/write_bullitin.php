<?php header("Content-Type:text/html;charset=utf-8");
    include "../dbConnect.php";
    include "../REGISTER/session.php";
    $name=$_SESSION['name'];
    if (!isset($_SESSION['userid'])){
        echo "<script>alert('로그인 해주세요!');
        history.back();
        </script>";
    }else{
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>글쓰기</title>
</head>
<body>
    <form action="./write_php.php" method="post">
        제목 : <input type="text" name="title"><br>
        작성자 : <input type="text" disabled name="name" value="<?php echo $_SESSION['name']; ?>"><br>
        내용 : <input type="text" name="content"><br>
        <input type="submit" value="글 작성">
    </form>
</body>
</html>
<?php
    }
?>