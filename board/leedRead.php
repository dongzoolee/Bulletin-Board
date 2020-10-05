<?php header("Content-Type:text/html;charset=utf-8");
include "../dbInfo/dbConnect.php";
include '../session/session.php';
$idx = $_GET['boardid'];
$sql="SELECT * FROM bullitin WHERE idx='$idx'";
$res=$mysqli->query($sql);
$table=$res->fetch_array(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BULLETIN</title>
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Myeongjo:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700&display=swap" rel="stylesheet">
    <script src="../jquery-3.5.1.min.js"></script>
    <script src="https://kit.fontawesome.com/43c7ad30c1.js" crossorigin="anonymous"></script>
    <!--HEADER CSS-->    
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <style>
        body{
            position: absolute;
            width:100%;
            /* padding 110px을 제외한 높이 */
            height:85%;
        }
        #wrapper{
            position:relative;
            height: 100%;
        }
        #title_div{
            border-bottom-right-radius: 3px;
            border-bottom-left-radius: 3px;
            box-shadow: 0 0 4px black;
            border-top:none;
            padding: 10% 0 4px 9px;
            margin-bottom: 13px;
        }
        #title{
            font-size: 3.5vw;
        }
        #info_div{
            border-radius: 1px;
            box-shadow: 0 0 4px black;
            padding: 2px 0 4px 9px;
        }
        #head_article{
            left:50%;
            position: absolute;
            transform: translate(-50%);
            font-family: "Noto Sans KR";
            width:66%;
            height:100%;
        }
        #cl_dat{
            height:25px;
            width: 100px;
            right:0;
            position:absolute;
            margin-right: 9px;
        }
        #content{
            border-radius: 1px;
            box-shadow: 0 0 4px black;
            border-bottom: none;
            margin: 9px 0 0 0;
            height: 100%;
        }
        #clock{
            width: 14px;
            height: 14px;
            margin: 0 2px 0 0;
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
        }
        #date{
            right: 0;
            position: absolute;
        }
        #editor{
            margin: 0 9px 0 9px;
        }
        @media (max-width: 1012px) {
            body{
                padding-top:12vw;
            }
            /* MOBILE BODY */
            #head_article{
                width:93vw;
            }
        }
    </style>
</head>

<body>
<div id="side_left">
        <div id="side_close"><img class="svg" src="../headerImg/backward-1.png" alt="close sidebar"></div>
    </div>
    <div id="header">
        <div id="logo">
            <a href="../main/leedMain.php"><span id="leed">LEED</span></a>
        </div>
        <span id="mob_cart"><a href="#"><img class="svg" src="../headerImg/shopping-1.png"></span></a>
        <span id="n3bars"><img class="svg" src="../headerImg/n3bars.png"></span>
        <div id="nav">
            <span id="nav_left">
                <span style="margin-left: -9px;"><a href="#"><i class="fab fa-facebook-f"></i></span></a>
                <span style="margin-left: 19px;"><a href="#"><i class="fab fa-instagram"></i></span></a>
                <span style="margin-left: 18px;"><a href="#"><i class="fab fa-youtube"></i></span></a>
            </span>
            <span id="nav_right">
                <span><a href="#"><i class="fas fa-search"></i></span></a>
                <span style="margin-left: 17px;"><a href="../login/leedLogin.php" onclick="window.open(this.href,'_blank','width=500px, height=500, left=700, top=50%, toolbars=no,scrollbars=no'); return false;"><i class="far fa-user"></i></span></a>
                <span style="margin-left: 17px;"><a href="#"><i class="fas fa-shopping-cart"></i></span></a>
            </span>
            <span id="nav_main">
                <span id="about"><a href="#">ABOUT</span></a>
                <span id="shop"><a href="#">SHOP</span></a>
                <span id="lookbook"><a href="../board/leedBoard.php">BULLETIN</span></a>
                <span id="community"><a href="#">COMMUNITY</span></a>
            </span>
        </div>
    </div>
    <div id="wrapper"> 
        <div id="head_article">
            <div id="title_div"><span id="title"><?php echo $table['title']; ?></span></div>
            <div id="info_div"><span id="name"><?php echo $table['name']; ?></span>
            <!--작성자에게만 수정 삭제 버튼이 보임-->
            <?php
            if($_SESSION['unq_num'] == $table['unq_num'])
                echo "<button id=\"edit\" onclick=\"edit($idx)\">수정</button><button id=\"del\" onclick=\"del($idx)\">삭제</button>";
            ?>
            <span id="cl_dat"><img id ="clock" src="./img/clock-1.png"><span id="date"><?php echo $table['date']; ?></span></span></div>
            <div id="content"><div id="editor"><?php echo $table['content']; ?></div>
        </div>
    </div>
    <script>
    // CKEDITOR //
    function getid(){
        var id = decodeURIComponent(location.search.substr(location.search.indexOf("?") + 1));
        id=id.substr(8);
    }
    function edit(idx){
        location.href="https://leed.at/board/leedEdit.php?boardid="+idx;   
    }
    function del(idx){
        $.ajax({
            type:'POST',
            dataType:'json',
            url:'./delete.php',
            data:{
                idx:idx
            },
            success:function(json){
                if(json.res=='good'){
                    alert('삭제되었습니다.');
                    location.href="https://leed.at/leed/board/leedBoard.php";
                }else{
                    alert('오류가 발생했습니다.');
                    history.back();
                }
            },
            error:function(err){
                alert(err);
            }
        })
    }
</script>
</body>
</html>