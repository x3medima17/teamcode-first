<?
session_start();
include("fx.php");
db_conn();
$result=0;
if(user_auth("student")->status==1 || user_auth("teacher")->status==1) exit($status);
$login = stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["login"])));
$pass = md5(stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["pass"]))));
$type = stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["type"])));
if($login=='' || $pass=='' || $type=='') $result=1;
if($result!=1){
$data = login($login,$pass,$type);
$data = json_decode($data);
$result = $data->status;
}
print $result;
?>