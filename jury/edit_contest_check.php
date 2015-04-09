<?
session_start();
include("../lib/fx.php");
db_conn();
if(user_auth("teacher")==1) header("Location:index.php");
$data = json_decode(get_user_info($_SESSION['id'],"teacher"));
$user_id = $data->id;
$status=0;

$id= mysql_real_escape_string($_POST['cid']);
if($data->class !=0 ){
	$res = mysql_query("SELECT id FROM contests  WHERE id='$id' AND teacher_id='$user_id'");
if(mysql_num_rows($res)==0)$status=1;
}
if($status==1) exit($status);
////////////
date_default_timezone_set("Europe/Chisinau");
$title = stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["title"])));

$start = strtotime(stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["start"]))));
$end = strtotime(stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["end"]))));
if(gettype($start)!='integer' || gettype($end)!="integer") $status=1;
if($start>=$end) $status =1;
if($title=='') $status=1;
$res = mysql_query("SELECT id FROM contests WHERE (
	(start>='$start' AND start<='$end' AND end>='$start' AND end>='$end') OR
	(start>='$start' AND start<='$end' AND end>='$start' AND end<='$end') OR
	(start<='$start' AND start<='$end' AND end>='$start' AND end<='$end') OR
	(start<='$start' AND start<='$end' AND end>='$start' AND end>='end')) AND id!='$id' ") or die(mysql_error());
	
if(mysql_num_rows($res)!=0) $status=2;

if($status!=0) die("$status");
$res = mysql_query("UPDATE contests SET title='$title', start='$start', end='$end' WHERE id='$id'") or die(mysql_error());
if($res == true) echo('0'); else echo('1');

?>