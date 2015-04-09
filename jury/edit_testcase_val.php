<?
session_start();
include("../lib/fx.php");
db_conn();
if(user_auth("teacher")!=0)fail("../index.php");
$problem_id = mysql_real_escape_string($_POST["id"]);
$val = mysql_real_escape_string($_POST["val"]);
$test = mysql_real_escape_string($_POST["test"]);
$data = json_decode(get_user_info($_SESSION["user_id"],"teacher"));
$user_id= $data->id;
settype($val,"integer");
$res = mysql_query("SELECT * FROM problems WHERE teacher_id='$user_id' AND id='$problem_id'");
if(mysql_num_rows($res)==0)exit('1');
$row = mysql_fetch_assoc($res);
$info = json_decode($row["test_info"]);
$info->{$test}=$val;
$info = json_encode($info);
mysql_query("UPDATE problems SET test_info='$info' WHERE id='$problem_id'");
echo '0';
?>