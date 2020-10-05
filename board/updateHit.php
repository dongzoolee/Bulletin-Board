<?php
    header("Content-Type:text/html;charset=utf  -8");
    include "../dbInfo/dbConnect.php";
    include '../session/session.php';
    $reid=$_POST['reid'];
    $sql="UPDATE bullitin SET hit=hit+1 WHERE idx='$reid'";
    $res=$mysqli->query($sql);
    $sql="SELECT*FROM bullitin WHERE idx='$reid'";
    $res=$mysqli->query($sql);
    $table = $res->fetch_array(MYSQLI_ASSOC);
    $ret = $table['hit'];
    if($res){
        echo json_encode(array('res'=>$ret));
    }
?>