<?
session_start();
include("fx.php");
db_conn();
if($_SESSION) exit();
$status=0;
$input = mysql_real_escape_string($_POST["input"]);
$type = mysql_real_escape_string($_POST["type"]);
$val = mysql_real_escape_string($_POST["val"]);
$pass = mysql_real_escape_string($_POST["pass"]);
if($type=="teacher"){
if ($input=="teacher_name" && $val=='')$status=1;

	if($input=="teacher_surname" && $val=='')$status=1;
	if($input=="teacher_pass" && $val=='')$status=1;
	if($input=="teacher_tel" && $val=='') $status=1;
		
if($input == "teacher_pass_ch"){
	if($pass != $val || $val=='') $status =1;
	//echo "aa";
}
if($input == "teacher_login" ){
	$res = mysql_query("SELECT id FROM jury WHERE login='$val'");
	$r = mysql_query("SELECT id FROM users WHERE login='$val'");
	if(mysql_num_rows($res)>0 || $val=='' || mysql_num_rows($r)>0) $status=1;
}
if ($input == "teacher_email" ){
	$res = mysql_query("SELECT id FROM jury Where email='$val'");
	if(mysql_num_rows($res)>0 ||$val=='') $status=1;
}
}
if($type=="student"){
if ($val=='') $status=1;
if($input == "student_pass_ch")	if($pass != $val || $val=='') $status =1;
if($input == "student_login" ){
	$res = mysql_query("SELECT id FROM users WHERE login='$val'");
	if(mysql_num_rows($res)>0 ) $status=1;
}
	if ($input == "student_email" ){
	$res = mysql_query("SELECT id FROM users Where email='$val'");
	if(mysql_num_rows($res)>0 ) $status=1;
}
    if($input == "student_teacher"){
    	$a = explode(" ",$val);
    	$name = $a[1];
    	$surname= $a[0];
    	$res = mysql_query("SELECT id FROM jury WHERE name='$name' AND surname='$surname'") or die(mysql_error());
    	if(mysql_num_rows($res)==0) $status=1;
    }
}

echo $status;


?>