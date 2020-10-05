<?php 
header("Content-Type:text/html;charset=utf-8");

include "../dbInfo/dbConnect.php";
include "../session/session.php";

$idx=$_POST['idx'];
$sql = "DELETE FROM bullitin WHERE idx='$idx';";
$res1=$mysqli->query($sql);
// idx 재정렬 //
$sql = "ALTER TABLE bullitin AUTO_INCREMENT=1;";
$res=$mysqli->query($sql);
$sql = "SET @cnt = 0;";
$res=$mysqli->query($sql);
$sql = "UPDATE bullitin SET bullitin.idx =@cnt:=@cnt+1;";
$res=$mysqli->query($sql);

if($res1){
    echo json_encode(array('res'=>'good'));
}else{
    echo json_encode(array('res'=>'bad'));
}
?>