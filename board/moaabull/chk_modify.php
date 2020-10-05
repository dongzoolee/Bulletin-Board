<?php 
header("Content-Type:text/html;charset=utf-8");

include "../dbConnect.php";
include "../REGISTER/session.php";

$idx=$_POST['cut_idx'];
$sql="SELECT*FROM bullitin WHERE idx='$idx'";
$res=$mysqli->query($sql);
$table=$res->fetch_array(MYSQLI_ASSOC);
$unq=$table['unq_num'];
if($_SESSION['unq_num'] == $unq){
    echo json_encode(array('res'=>'good'));
}else{
    echo json_encode(array('res'=>'bad'));
}
?>