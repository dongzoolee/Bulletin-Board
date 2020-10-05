<?php 
header("Content-Type:text/html;charset=utf-8");
include "../dbConnect.php";
include "../REGISTER/session.php"; ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BULLITIN</title>	
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Myeongjo:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700&display=swap" rel="stylesheet">
    <script src="../jquery-3.5.1.min.js"></script>
    <script src="https://kit.fontawesome.com/43c7ad30c1.js" crossorigin="anonymous"></script>
    <!--HEADER CSS-->
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <style>
        /*BODY시작 */
        body {
            position: absolute;
            font-family: "Noto Sans KR", serif;
            font-weight: 400;
            width: 100%;
            /* padding 110px을 제외한 높이 */
            height:85%;
        }
        #wrapper{
            height:100%;
        } 
        #content{
            top:10%;
            left:50%;
            transform: translate(-50%);
            position: relative;
            width: 66%;
            height:100%;
        }
        caption{
            text-align: left;
        }
        #caption{
            margin:0 0 10px 10px;
        }
        table{
            position:relative;
            width:100%;
            border-collapse : collapse;
        }
        th{
            text-align: center;
            border-top:2px solid green;
        }
        td{
            text-align: center;
            border-top:1px solid lightgray;
            height:40px;
        }
        .idx{
            width:100px;
        }
        .title{
            width:600px;
        }
        .name{
            width:120px;
        }
        .date{
            width:120px;
        }
        .hit{
            width:100px;
        }
        #write{
            position: absolute;
            right:0;
            top:2%;
            border: 1px solid grey;
            background-color: #fff;
            width: 80px;
            height: 29px;
            padding:2px 6px 0 6px;
        }
        @media (max-width: 1012px) {
            body{
                padding-top:12vw;
            }
            /* MOBILE BODY */
            #content{
                width:90%;
            }
            table{
                top:3vw;
                width:100%;
            }
            .date{
                width:200px;
            }
            #write{
                top:5vw;
            }
        }
    </style>
</head>
<body>
<div id="side_left">
        <div id="side_close"><img class="svg" src="../logo/backward-1.png" alt="close sidebar"></div>
    </div>
    <div id="header">
        <div id="logo">
            <a href="../"><span id="moaa">MOAA</span></a>
        </div>
        <span id="mob_cart"><a href="#"><img class="svg" src="../logo/cart-1.png"></span></a>
        <span id="n3bars"><img class="svg" src="../logo/3bars-1.png"></span>
        <div id="nav">
            <span id="nav_left">
                <span style="margin-left: -9px;"><a href="#"><i class="fab fa-facebook-f"></i></span></a>
                <span style="margin-left: 19px;"><a href="#"><i class="fab fa-instagram"></i></span></a>
                <span style="margin-left: 18px;"><a href="#"><i class="fab fa-youtube"></i></span></a>
            </span>
            <span id="nav_right">
                <span><a href="#"><i class="fas fa-search"></i></span></a>
                <span style="margin-left: 17px;"><a href="../MOAA_login.php"><i class="far fa-user"></i></span></a>
                <span style="margin-left: 17px;"><a href="#"><i class="fas fa-shopping-cart"></i></span></a>
            </span>
            <span id="nav_main">
                <span id="about"><a href="#">ABOUT</span></a>
                <span id="lookbook"><a href="./moaa_bul.php">BULLITIN</span></a>
                <span id="shop"><a href="#">SHOP</span></a>
                <span id="community"><a href="#">COMMUNITY</span></a>
            </span>
        </div>
    </div>
    <div id="wrapper">
        <div id="content">
            <table>
            <caption><h1 id="caption">방명록을 남겨주세요</h1></caption>
            <tr>
                <th class="idx">번호</th>
            <th class="title">제목</th>
            <th class="name">작성자</th>
            <th class="date">날짜</th>
            <th class="hit">조회수</th>
        </tr>
        <?php
        $sql = ("SELECT * FROM bullitin order by idx desc");
        $res = $mysqli->query($sql);
        while ($board = $res->fetch_array(MYSQLI_ASSOC)) {
            $title = $board["title"];
            if (strlen($title) > 25) {
                $title = str_replace($board["title"], mb_substr($board["title"], 0, 25, "utf-8") . "...", $board["title"]);
            }
            ?>
            <tr>
                <td class="idx"><?php echo $board["idx"]; ?></td>
                <td class="title" id="board<?php echo $board['idx']; ?>" onclick="opentext(this.id);" onmouseout="outtext(this);" onmouseover="overtext(this);" style="cursor:pointer;" class="title">
                    <div><?php echo $title; ?></div>
                </td>
                <td class="name"><?php echo $board["name"]; ?></td>
                <td class="date"><?php echo $board["date"]; ?></td>
                <td class="hit" id="hit<?php echo $board['idx']; ?>"><?php echo $board["hit"]; ?></td>
            </tr>
            <!--<tr style="width:100%;">
                <td id="content_td_<?php echo $board['idx']; ?>" colspan="5" style="width:100%;">
                    <span><div class="content" id="<?php echo $board['idx']; ?>">
                        <?php echo $board['content']; ?>
                    </div></span> -->
                    <!-- <button class="edit_btn" id="edit<?php echo $board['idx']; ?>" onclick="chk_edit(this.id);">수정</button>
                    <button class="del_btn" id="del<?php echo $board['idx']; ?>" onclick="chk_del(this.id);">삭제</button> 
                </td>
            </tr>-->
            <?php } ?>
        </table>
        <button id="write" style="cursor:pointer;" onclick="is_login();">글쓰기</button>
    </div>
</div>
    <div id="footer">
        </div>
        <script>
        // MOBILE HEADER   
        $(function() {
            $('#n3bars').click(function() {
                $('#side_left').fadeIn();
                $("body").css('overflow', 'hidden').css('display', 'fixed');
            });
            $('#side_close').click(function() {
                $('#side_left').fadeOut();
                $('body').css('overflow', '').css('display', '');
            });
        });

        //BODY
        function is_login() {
            var ret;
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: './is_login.php',
                success: function(json) {
                    ret = json.ret;
                    if (ret == 'false') {
                        // 이건 include로 구현하는게 아니다...
                        alert("로그인 해주세요!");
                        location.href = "../MOAA_login.php";
                        //window.open("../MOAA_login.php", '_blank', 'width=500px, height=500, left=700, top=50%, toolbars=no,scrollbars=no');
                    } else {
                        location.href = "./moaa_write_bul.php";
                    }
                }
            });

        }
        function opentext(id){
            id = id.substr(5);
            location.href="./moaa_read.php?boardid="+id;
            update_hit(id);
        }
        function update_hit(reid) {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: './read.php',
                data: {
                    reid: reid
                },
                success: function(json) {
                    console.log('hit success');
                    document.getElementById("hit" + reid).innerHTML = json.res;
                },
                error: function() {
                    console.log('hit failed');
                }
            });
        }

        function overtext(obj) {
            obj.style.color = "green";
        }

        function outtext(obj) {
            obj.style.color = "black";
        }

    </script>
</body>
</html>