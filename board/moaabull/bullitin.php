<?php header("Content-Type:text/html;charset=utf-8");
include "../dbConnect.php";
include "../REGISTER/session.php"; ?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>방명록</title>
    <script src="../jquery-3.5.1.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: "Noto Sans KR", serif;
        }
        table{
            width:100%; /*#화면 꽉채워서*/
            border:1px solid #444444;
            border-collapse : collapse;
        }
        td{
            border-top:1px solid;
            border-right:1px solid;
            border-left:1px solid;
            border-bottom: 0;
            border-collapse:collapse;
        } 
        tr
        th{
            border:1px solid #444444;
            border-collapse : collapse;
        }
        button {
            cursor: pointer;
        }

        a {
            text-decoration: none;
            color: black;
        }

        tr {
            text-align: center;
        }

        .content {
            box-sizing: border-box;
            display: none;
            border: 1px solid black;
            width:100%;
            padding: 0;
        }

        .title {
            user-select: none;
        }

        .del_btn {
            display: none;
            position: relative;
        }

        .edit_btn {
            display: none;
            position: relative;
            left: 0;
            top: 0;
        }
    </style>
</head>

<body>
    <h1>방명록을 남겨주세요</h1>
    <table>
        <tr>
            <th>번호</th>
            <th>제목</th>
            <th>작성자</th>
            <th>날짜</th>
            <th>조회수</th>
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
                <td><?php echo $board["idx"]; ?></td>
                <td id="board<?php echo $board['idx']; ?>" onclick="opentext(this.id);" onmouseout="outtext(this);" onmouseover="overtext(this);" style="cursor:pointer;" class="title">
                    <div><?php echo $title; ?></div>
                </td>
                <td><?php echo $board["name"]; ?></td>
                <td><?php echo $board["date"]; ?></td>
                <td id="hit<?php echo $board['idx']; ?>"><?php echo $board["hit"]; ?></td>
            </tr>
            <tr style="width:100%;">
                <td id="content_td_<?php echo $board['idx']; ?>" colspan="5" style="width:100%;">
                    <span><div class="content" id="<?php echo $board['idx']; ?>">
                        <?php echo $board['content']; ?>
                    </div></span>
                    <button class="edit_btn" id="edit<?php echo $board['idx']; ?>" onclick="chk_edit(this.id);">수정</button>
                    <button class="del_btn" id="del<?php echo $board['idx']; ?>" onclick="chk_del(this.id);">삭제</button>
                </td>
            </tr>
        <?php } ?>
    </table>
    <button id="write" style="cursor:pointer;" onclick="is_login();">글쓰기</button>
    <script>
        var opend = -1,
            closd = 1;

        function opentext(id) {
            var reid = id.substr(5);
            // 여닫기
            if (opend == -1) {
                closd = 0;
                document.getElementById(reid).style = "display:inline-block";
                document.getElementById("edit" + reid).style = "display:inline-block";
                document.getElementById("del" + reid).style = "display:inline-block";
                opend = reid;
                update_hit(reid);
            } else if (opend == reid) {
                if (closd == 1) {
                    document.getElementById(reid).style = "display:inline-block";
                    document.getElementById("edit" + reid).style = "display:inline-block";
                    document.getElementById("del" + reid).style = "display:inline-block";
                    closd = 0;
                    update_hit(reid);
                } else {
                    document.getElementById(reid).style = "display:none";
                    document.getElementById("edit" + reid).style = "display:none";
                    document.getElementById("del" + reid).style = "display:none";
                    closd = 1;
                }
            } else {
                closd = 0;
                document.getElementById(opend).style = "display:none";
                document.getElementById("edit" + opend).style = "display:none";
                document.getElementById("del" + opend).style = "display:none";
                document.getElementById(reid).style = "display:inline-block";
                document.getElementById("edit" + reid).style = "display:inline-block";
                document.getElementById("del" + reid).style = "display:inline-block";
                opend = reid;
                update_hit(reid);
            }
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
            obj.style.color = "red";
        }

        function outtext(obj) {
            obj.style.color = "black";
        }

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
                        window.open("../REGISTER/login.php", '_blank', 'width=500px, height=500, left=700, top=50%, toolbars=no,scrollbars=no');
                    } else {
                        location.href = "./write_bullitin.php";
                    }
                }
            });

        }
        var editing = 0;
        function chk_edit(obj_idx) {
            var cut_idx = obj_idx.substr(4);
            // 아작스 통신은
            // 스크립트 안에 스크립트 만들 수 없습니다
            // 제발요 기억해주세요 부탁드립니다.
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: './chk_modify.php',
                data: {
                    cut_idx: cut_idx
                },
                success: function(json) {
                    if (json.res == 'good') {
                        if(editing == 0){
                        $prev = $("#"+cut_idx).text();
                        $prev=$.trim($prev);
                        $(function(){
                            $("#content_td_"+cut_idx+" > span").html("<input class='content' style='display:inline-block;' value='"+$prev+"' id='"+cut_idx+"'></input>");
                        });
                        editing = 1;
                        }else{
                            var to_update=$("#"+cut_idx).val();
                            modify(cut_idx, to_update);
                        }
                    } else {
                        alert("권한이 없습니다");
                    }
                },
                error: function(json) {
                    alert("관리자에게 문의해주세요");
                }
            });
        }
        function modify(idx, con){
        var ret;
            $.ajax({
                type:'post',
                dataType:'json',
                url:'./modify.php',
                data:{idx:idx,con:con},
                success:function(json){
                    if(json.res == "good"){
                        console.log("good");
                        alert("변경완료");
                        location.reload();
                    }else{
                        alert("문제가 발생했습니다.");
                    }
                },
                error:function(json){
                    console.log("bad protocol");
                    ret=json.res;
                },
            });
            return ret;
        }
        function chk_del(obj_idx) {
            var cut_idx = obj_idx.substr(3);
            // 아작스 통신은
            // 스크립트 안에 스크립트 만들 수 없습니다
            // 제발요 기억해주세요 부탁드립니다.
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: './chk_modify.php',
                data: {
                    cut_idx: cut_idx
                },
                success: function(json) {
                    if (json.res == 'good') {
                        if (confirm('삭제하시겠습니까?')) {
                            del(cut_idx);
                            alert("삭제되었습니다");
                            location.reload();
                        }
                    } else {
                        alert("권한이 없습니다");
                    }
                },
                error: function(json) {
                    alert("관리자에게 문의해주세요");
                }
            });
        }
        function del(idx) {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: './delete.php',
                data: {
                    idx: idx
                },
            });
        }
    </script>
</body>

</html>