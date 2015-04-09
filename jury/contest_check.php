<?
session_start();
include("../lib/fx.php");
db_conn();
if(user_auth("teacher")!=0) exit('2');
$type = $_POST["type"];

if($type=="add"){
	$data = json_decode(get_user_info($_SESSION["user_id"],"teacher"));
$id = $data->id;
$status=0;
date_default_timezone_set("Europe/Chisinau");
$title = stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["title"])));

$start = strtotime(stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["start"]))));
$end = strtotime(stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["end"]))));
if(gettype($start)!='integer' || gettype($end)!="integer") $status=1;
if($start>=$end) $status =1;
if($title=='') $status=1;
$res = mysql_query("SELECT id FROM contests WHERE 
	(start>='$start' AND start<='$end' AND end>='$start' AND end>='$end') OR
	(start>='$start' AND start<='$end' AND end>='$start' AND end<='$end') OR
	(start<='$start' AND start<='$end' AND end>='$start' AND end<='$end') OR
	(start<='$start' AND start<='$end' AND end>='$start' AND end>='end') ") or die(mysql_error());
if(mysql_num_rows($res)!=0) $status=1;
if($status==0){
mysql_query("INSERT INTO contests (title,start,end,teacher_id) VALUES ('$title','$start','$end','$id')");
$id = mysql_insert_id();
$old = umask(0);
mkdir("../contests/$id",0777);
umask($old);
echo 0;
}
else echo 1;
}

?>