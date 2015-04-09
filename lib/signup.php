<?
session_start();
$n = $_POST["n"];
if($n!=0) exit("There are wrong fields");
include("fx.php");
db_conn();
if($_SESSION) exit();
$type = $_POST["type"];
if ($type=="teacher"){
$login = stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["login"]))); 
$name = stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["name"]))); 
$surname = stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["surname"]))); 
$pass = md5(stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["pass"]))));
$email = stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["email"])));
$tel = stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["tel"])));
if ($login == '' || $name == '' || $surname=='' || $pass=='' || $email=='' || $tel=='') $result.="There are empty fields<br>";
$res = mysql_query("SELECT * FROM jury WHERE login='$login'");
	$r = mysql_query("SELECT id FROM users WHERE login='$login'");

if(mysql_num_rows($res)>0 || mysql_num_rows($r)>0) $result.="Login exists<br>";
$res = mysql_query("SELECT * FROM jury WHERE email='$email'");
if(mysql_num_rows($res)>0) $result.="E-mail exists<br>";
if (!preg_match("/^[A-Za-z0-9_]+$/",$login)) $result.="Incorrect login<br>";
if (!preg_match("/^[A-Za-z0-9_]+$/",$name)) $result.="Incorrect name<br>";
if (!preg_match("/^[A-Za-z0-9_]+$/",$surname)) $result.="Incorrect surname<br>"; 
if (!preg_match("/^[0-9]+$/",$tel)) $result.="Incorrect telephone<br>";
if($result==''){
mysql_query("INSERT INTO jury (login,name,pass,surname,email,tel,class) VALUES ('$login','$name','$pass','$surname','$email','$tel','1')") or die(mysql_error());
$idd = mysql_insert_id();
mysql_query("INSERT INTO users (name,surname,login,email,pass,school,teacher_id) VALUES ('$name','$surname','$login','$email','$pass','','$idd')") or die(mysql_error());

echo "Your request has been sent.";
}
else echo $result;
}
if($type=="student"){
$login = stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["login"]))); 
$name = stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["name"]))); 
$surname = stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["surname"]))); 
$pass = md5(stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["pass"]))));
$email = stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["email"])));
$teacher = stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["teacher"])));
$school = stripslashes(htmlspecialchars(mysql_real_escape_string($_POST["school"])));
if ($login == '' || $name == '' || $surname=='' || $pass=='' || $email=='' || $school=='' || $teacher=='') $result.="There are empty fields<br>";

$res = mysql_query("SELECT id FROM users WHERE login='$login'");
if(mysql_num_rows($res)>0) $result.="Login exists<br>";
$res = mysql_query("SELECT * FROM users WHERE email='$email'");
if(mysql_num_rows($res)>0) $result.="E-mail exists<br>";

if (!preg_match("/^[A-Za-z0-9_]+$/",$login)) $result.="Incorrect login<br>";
if (!preg_match("/^[A-Za-z0-9_]+$/",$name)) $result.="Incorrect name<br>";
if (!preg_match("/^[A-Za-z0-9_]+$/",$surname)) $result.="Incorrect surname<br>"; 

$a = explode(" ",$teacher);
$name1 = $a[1]; $surname1=$a[0];
$res = mysql_query("SELECT id FROM jury WHERE name='$name1' AND surname='$surname1'");
if(mysql_num_rows($res)==0) $result.="Teacher doesn't exist<br>";

if($result==''){
$row = mysql_fetch_array($res);
$teacher_id=$row[id];
mysql_query("INSERT INTO users (name,surname,login,email,pass,school,teacher_id) VALUES ('$name','$surname','$login','$email','$pass','$school','$teacher_id')") or die(mysql_error());

$id = mysql_insert_id();
$old = umask(0);
mkdir("../upload/$id",0777);
umask($old);
echo "Signup OK.<br> Now you can <a href=index.php>Login</a>";
}
else echo $result;
}

?>