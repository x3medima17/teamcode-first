<?
session_start();
include("../lib/fx.php");
db_conn();

if(user_auth("teacher")!=0)return '1';
$id = mysql_real_escape_string($_POST['id']);
mysql_query("DELETE FROM judge WHERE submission_id='$id'") or die(mysql_error());
mysql_query("UPDATE submissions SET result='',total='0' WHERE id='$id'") or die(mysql_error());;
echo '0';

?>