<?
session_start();
include("../lib/fx.php");
db_conn();

if(user_auth("teacher")!=0)fail("../index.php");
$id = mysql_real_escape_string($_POST["id"]);
$value = mysql_real_escape_string($_POST["value"]);
if($id=='' || $value=='' || $_FILES["in"]["name"]=='' || $_FILES["in"]["name"]=='') exit('4');
$data = json_decode(get_user_info($_SESSION["user_id"],"teacher"));
$user_id = $data->id;
$res = mysql_query("SELECT * FROM problems WHERE teacher_id='$user_id' AND id='$id'");

if(mysql_num_rows($res)==0) exit('1');

$row = mysql_fetch_assoc($res);

$cid = $row["contest_id"];
$sc = $row["script"];
$n = $row["testcases"]+1;
$info = json_decode($row["test_info"]);
$a = array();
foreach($info as $key=>$val){
	$a[$key]=$val;
}
array_push($a,$value);
$info = json_encode($a);
////////////// IN ///////////
$ext = explode('.',$_FILES["in"]["name"]);
$ext = end($ext);
if($ext!='in') exit('2');
/////////// OUT ////////////
if($sc!='1'){
$ext = explode('.',$_FILES["out"]["name"]);
$ext = end($ext);
if($ext!='ok') exit('3');
 move_uploaded_file($_FILES["out"]["tmp_name"], "../contests/$cid/$id/$n.ok");
exec("dos2unix ../contests/$cid/$id/$n.ok");
 
}
 move_uploaded_file($_FILES["in"]["tmp_name"], "../contests/$cid/$id/$n.in");


 exec("dos2unix ../contests/$cid/$id/$n.in");
 mysql_query("UPDATE problems SET testcases='$n',test_info='$info' WHERE id='$id'");
 exec("chmod -R 777 ../contests/$cid/$id");
 echo "0";
 
?>