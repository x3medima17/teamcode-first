<?
session_start();
include("../lib/fx.php");
db_conn();

if(user_auth("teacher")!=0)	fail("../index.php");
$data = json_decode(get_user_info($_SESSION["user_id"],"teacher"));
$user_id = $data->id;
$id = mysql_real_escape_string($_GET["problem_id"]);
$res = mysql_query("SELECT * FROM problems WHERE id = '$id' and teacher_id='$user_id'");
if(mysql_num_rows($res)==0) fail("index.php");
$row = mysql_fetch_array($res);
$data = json_decode($row["test_info"]);
$n = $row["testcases"];	
$cid = $row["contest_id"];
for($i=1;$i<=$n;$i++){
$dir = "../contests/$cid/$id/";
$in = $dir.$i.".in";
$out = $dir.$i.".ok";
if(file_exists($in)) unlink($in);
if(file_exists($out)) unlink($out);
}
mysql_query("UPDATE problems SET testcases='0',test_info='' WHERE id='$id'");
header("Location:testcases.php?problem_id=$id"); 


?>