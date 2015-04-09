<?
session_start();
include("lib/fx.php");
db_conn();
if(user_auth("student")!=0) return('1');
$data = json_decode(get_user_info($_SESSION["user_id"],"student"));
$user_id = $data->id;
$contest_id = mysql_real_escape_string($_POST['contest_id']);
$text = mysql_real_escape_string($_POST["text"]);
mysql_query("INSERT INTO questions (contest_id,user_id,question) VALUES ('$contest_id','$user_id','$text')");

?>