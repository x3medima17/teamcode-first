<?
session_start();
include("lib/fx.php");
db_conn();
if(!$SESSION) fail("index.php");
$type = $_SESSION["type"];
if($type=="teacher"){
$teacher = json_decode(get_user_info($_SESSION["user_id"],'teacher'));
$login = $teacher->login;
$pass = $teacher->pass;
$res = mysql_query("SELECT * FROM users WHERE login='$login' AND pass='$pass'");
if(mysql_num_rows($res)==0)fail("index.php");
$row = mysql_fetch_assoc($res);
$_SESSION["type"]='student';
$_SESSION["user_id"]=$row["id"];
$_SESSION["key"]=$row["accesskey"];
header("Location:index.php");
}elseif($type=="student"){
$student = json_decode(get_user_info($_SESSION["user_id"],'student'));
$login = $student->login;
$pass = $student->pass;
$res = mysql_query("SELECT * FROM jury WHERE login='$login' AND pass='$pass' AND active='1'");
if(mysql_num_rows($res)==0)fail("index.php");
$row = mysql_fetch_assoc($res);
$_SESSION["type"]='teacher';
$_SESSION["user_id"]=$row["id"];
$_SESSION["key"]=$row["accesskey"];
header("Location:jury/index.php");
}

?>