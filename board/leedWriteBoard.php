<?php header("Content-Type:text/html;charset=utf-8");
include "../dbInfo/dbConnect.php";
include '../session/session.php';
$name = $_SESSION['name'];
if (!isset($_SESSION['userid'])) {
    echo "<script>alert('로그인 해주세요!');
        history.back();
        </script>";
} else {
?>
    <!DOCTYPE html>
    <html lang="ko">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>글쓰기</title>
        <link href="https://fonts.googleapis.com/css2?family=Nanum+Myeongjo:wght@400;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700&display=swap" rel="stylesheet">
        <script src="../jquery-3.5.1.min.js"></script>
        <script src="https://kit.fontawesome.com/43c7ad30c1.js" crossorigin="anonymous"></script>
        <!--EDITOR-->
        <script src="../plug-in/ckeditor4/ckeditor.js"></script>
        <!--HEADER CSS-->
        <link rel="stylesheet" type="text/css" href="../css/header.css">
        <script src="../js/header.js"></script>

        <style>
            /*BODY시작 */
            body {
                font-family: "Noto Sans KR", serif;
            }

            #write_field {
                box-sizing: border-box;
                width: 100%;
                border: none;
                border-top: 0.5px solid green;
                border-bottom: 0.5px solid green;
                position: relative;
                margin: 0;
                top: 30px;
            }

            input {
                border: none;
                height: 31px;
                color: black;
                background-color: lightgrey;
                font-family: "Noto Sans KR", serif;
                padding-left: 8px;
            }

            #title {
                width: 60%;
                margin-bottom: 5px;
            }
            @media (max-width: 1012px) {
                body {
                    padding-top: 12vw;
                }

                /* MOBILE BODY */
                #write_field {
                    padding: 2vw;
                    width: 93vw;
                }

                #title {
                    width: 95vw;
                    box-sizing: border-box;
                }

                #name {
                    width: 30vw;
                    margin: 0 0 5px 0;
                    float: left;
                    box-sizing: border-box;
                }

                #date {
                    width: 64vw;
                    margin: 0 0 5px 1vw;
                    box-sizing: border-box;
                }
            }
        </style>
    </head>

    <body onload="loadck();">
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
                    <span style="margin-left: 17px;"><a href="../login/leedLogin.php"><i class="far fa-user"></i></span></a>
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
        <!-- 글쓰기 -->
        <form action="./sendWrite.php" method="post" onsubmit="return field_chk();">
            <fieldset id="write_field">
                <input type="text" name="title" id="title" placeholder="제목">
                <input type="text" disabled name="name" id="name" value="<?php echo $_SESSION['name']; ?>">
                <input type="text" disabled id="date"><br>
                <textarea id="editor" name="content"></textarea><br>
                <div id="live" style="display:none"></div>
                <input type="submit" style="cursor:pointer;" value="글 작성">
            </fieldset>
        </form>
        <div id="footer">
        </div>
        <script>
            var str = new Date().toLocaleString();
            str = str.replace('. ', '-');
            str = str.replace('. ', '-');
            str = str.replace('.', ' ');
            document.getElementById("date").value = str;
            // CKEDITOR // 
            function loadck() {
                CKEDITOR.replace('editor', {});
                CKEDITOR.instances.editor.updateElement();
            }
            //BODY
            function is_login() {
                var ret;
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: '../login/isLogin.php',
                    success: function(json) {
                        ret = json.ret;
                        if (ret == 'false') {
                            // 이건 include로 구현하는게 아니다...
                            alert("로그인 해주세요!");
                            window.open("../login/leedLogin.php", '_blank', 'width=500px, height=500, left=700, top=50%, toolbars=no,scrollbars=no');
                        } else {
                            location.href = "./board/leedWriteBoard.php";
                        }
                    }
                });
            }

            function field_chk() {
                if (document.getElementById("title").value != "" && CKEDITOR.instances.editor.getData() != "") {
                    return true;
                } else {
                    alert("제목과 내용을 모두 채워주세요.");
                    return false;
                }
            }
        </script>
    </body>

    </html>
<?php
}
?>