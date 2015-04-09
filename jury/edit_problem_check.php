<?
session_start();
include("../lib/fx.php");
db_conn();
if(user_auth("teacher")==1) exit(fail("index.php"));
$data = json_decode(get_user_info($_SESSION["user_id"],"teacher"));
$user_id = $data->id;

$title = stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["title"])));
$timelimit = stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["timelimit"])));
$contest_id = stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["contest_id"])));
$problem_id = stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["problem_id"])));
if($title=='' || $timelimit=='' || $contest_id=='' || $problem_id=='') exit($contest_id);
$res = mysql_query("SELECT * FROM problems WHERE id='$problem_id' AND teacher_id='$user_id'") or die(mysql_error());
$r1 = mysql_query("SELECT id FROM contests WHERE id='$contest_id' AND teacher_id='$user_id'")or die(mysql_error());
if(mysql_num_rows($res)==0 || mysql_num_rows($r1)==0) exit('2');
$row = mysql_fetch_assoc($res);
mysql_query("UPDATE problems SET title='$title',timelimit='$timelimit',contest_id='$contest_id' WHERE id='$problem_id'");
echo 0;
   
?>