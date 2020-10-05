<?php
header("Content-Type:text/html;charset=utf-8");
error_reporting(E_ALL);
ini_set("display_errors", 1);
include "../dbInfo/dbConnect.php";
include '../session/session.php'; ?>
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
    <script src="../js/header.js"></script>
    <!--HEADER CSS-->
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <style>
        /*BODY시작 */
        body {
            position: absolute;
            font-weight: 400;
            width: 100%;
            /* padding 110px을 제외한 높이 */
            height: 85%;
        }

        #wrapper {
            height: 100%;
        }

        #content {
            top: 10%;
            left: 50%;
            transform: translate(-50%);
            position: relative;
            width: 70%;
            height: 100%;
        }

        caption {
            text-align: left;
        }

        #caption {
            margin: 0 0 10px 10px;
        }

        table {
            position: relative;
            width: 100%;
            border-collapse: collapse;
        }

        .theadIdx {
            font-size: 2px;
            width: 44px;
        }

        .theadTitle {
            font-size: 2px;
        }

        th {
            text-align: center;
            border-top: 2px solid green;
        }

        td {
            text-align: center;
            border-top: 1px solid lightgray;
            height: 40px;
        }

        .idx {
            width: 21px;
            font-size: 13px;
        }

        .title {
            width: 600px;
            height: 35px;
            font-size: 15px;
        }

        .tInfo {
            height: 23px;
            font-size: 12px;
        }

        .name {
            width: 120px;
        }

        .date {
            width: 120px;
        }

        .hit {
            width: 100px;
        }

        #write {
            position: absolute;
            right: 0;
            top: 2%;
            border: 1px solid grey;
            background-color: #fff;
            width: 80px;
            height: 29px;
            padding: 2px 6px 0 6px;
        }

        @media (max-width: 1012px) {
            body {
                padding-top: 12vw;
            }

            /* MOBILE BODY */
            #content {
                width: 90%;
            }

            table {
                top: 3vw;
                width: 100%;
            }

            .idx {
                width: 12vw;
                font-size: 2vw;
            }

            .title {
                font-size: 2.5vw;
                width: 139vw;
            }

            .date {
                width: 30vw;
                font-size: 2vw;
            }

            .name {
                width: 34vw;
                font-size: 2vw;
            }

            .hit {
                width: 15vw;
                font-size: 2vw;
            }

            #write {
                top: 5vw;
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
    <div id="wrapper">
        <div id="content">
            <table>
                <caption>
                    <h1 id="caption">방명록을 남겨주세요</h1>
                </caption>
                <thead>
                    <tr>
                        <th class="theadIdx" rowspan="2">Index</th>
                        <th class="theadTitle" colspan="4">Content</th>
                    </tr>
                </thead>
                <?php
                $sql = "SELECT * FROM bullitin order by idx desc";
                $res = $mysqli->query($sql);
                while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
                    $title = $row["title"];
                    if (strlen($title) > 90) {
                        $title = str_replace($row["title"], mb_substr($row["title"], 0, 90, "utf-8") . "...", $row["title"]);
                    }
                ?>
                    <tbody>
                        <tr>
                            <td class="idx" rowspan="2"><?php echo $row["idx"]; ?></td>
                            <td class="title" colspan="4" id="board<?php echo $row['idx']; ?>" onclick="opentext(this.id);" onmouseout="outtext(this);" onmouseover="overtext(this);" style="cursor:pointer;" class="title">
                                <div><?php echo $title; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="name tInfo"><?php echo $row["name"]; ?></td>
                            <td class="tInfo"></td>
                            <!--그냥 여백-->
                            <td class="date tInfo"><?php echo $row["date"]; ?></td>
                            <td class="hit tInfo" id="hit<?php echo $row['idx']; ?>"><?php echo $row["hit"]; ?></td>
                        </tr>
                    </tbody>
                <?php } ?>
            </table>
            <button id="write" style="cursor:pointer;" onclick="is_login();">글쓰기</button>
        </div>
    </div>
    <div id="footer">
    </div>
    <script>
        function overtext(obj) {
            obj.style.color = "green";
        }

        function outtext(obj) {
            obj.style.color = "black";
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
                        location.href = "../login/leedLogin.php";
                        //window.open("../leed_login.php", '_blank', 'width=500px, height=500, left=700, top=50%, toolbars=no,scrollbars=no');
                    } else {
                        location.href = "./leedWriteBoard.php";
                    }
                }
            });

        }

        function opentext(id) {
            id = id.substr(5);
            location.href = "./leedRead.php?boardid=" + id;
            update_hit(id);
        }

        function update_hit(reid) {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: './updateHit.php',
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
    </script>
</body>

</html>