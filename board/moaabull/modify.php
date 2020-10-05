<?php
include "../dbConnect.php";
include "../REGISTER/session.php";
if(!isset($_SESSION['userid'])){
    echo json_encode(array('res'=>'bad'));
}else{
    $idx=$_POST['idx'];
    $con=$_POST['con'];
    $sql="UPDATE bullitin SET content='$con' WHERE idx='$idx'";
    $res=$mysqli->query($sql);
    if($res){
        echo json_encode(array('res'=>'good'));
    }else{
        echo json_encode(array('res'=>'bad'));
    }
}
?>