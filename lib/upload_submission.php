<?
session_start();
include("../lib/fx.php");
db_conn();

if(user_auth("student")!=0) exit('1');
$data = json_decode(get_user_info($_SESSION["user_id"],"student"));
$user_id= $data->id;
$last_submit = $data->last_submit;
$teacher_id = $data->teacher_id;
$problem_id = mysql_real_escape_string($_POST["problem_id"]);
$contest_id= mysql_real_escape_string($_POST["contest_id"]);

$res = mysql_query("SELECT * FROM problems WHERE teacher_id='$teacher_id' AND id='$problem_id'");
if(mysql_num_rows($res)==0) exit('2');

$row = mysql_fetch_assoc($res);

$time = time();

if(validate_upload_time($time,$contest_id)!='0') exit('3');
if($last_submit+300 < time()) {

$now = time();
mysql_query("UPDATE users SET last_submit='$last_submit' WHERE id='$user_id'");
	//exit('3');
}

$file_name = $_FILES["file"]["name"];
$ext = explode(".",$file_name);
$ext = end($ext);
if($ext != 'c' && $ext !='cpp' && $ext !='pas') exit('4');

if(validate_script($_FILES['file']["tmp_name"])!=0) exit('5');
////////

$res = mysql_query("SHOW TABLE STATUS LIKE 'submissions'");
$row = mysql_fetch_assoc($res);
$id= $row['Auto_increment'];
move_uploaded_file($_FILES["file"]["tmp_name"], "../upload/$user_id/$id.$ext");
mysql_query("INSERT INTO submissions (user_id,problem_id,contest_id,lang,time) VALUES ('$user_id','$problem_id','$contest_id','$ext','$time')") 
or die(mysql_error());
$now = time();
mysql_query("UPDATE users SET last_submit='$now' WHERE id='$user_id'");
exec("chmod 777 ../upload/$user_id/$id.$ext");
echo "0";
?>