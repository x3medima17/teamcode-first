<?
$login = mysql_real_escape_string($_POST["login"]);
$pass = mysql_real_escape_string($_POST["pass"]);
$type = mysql_real_escape_string($_POST["type"]);
if($login!='' && $pass!='' && $type!=''){
if($type='student') $res = mysql_query("SELECT * FROM users WHERE login='$login' AND pass='$pass'");
else $res =  mysql_query("SELECT * FROM jury WHERE login='$login' AND pass='$pass' AND active='1'");
if (mysql_num_rows($res)!=0){
echo "<p style='color:#0f0'>Login accepted</p>";
}
else{
echo "<p style='color:#f00'>Login failed</p>";
}
}

?>