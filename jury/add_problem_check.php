<?
session_start();
include("../lib/fx.php");
db_conn();
if(user_auth("teacher")!=0) exit('1');
$data = json_decode(get_user_info($_SESSION["user_id"],"teacher"));
$user_id = $data->id;
exec("rm -rf tmp");
exec("mkdir tmp");
exec("chmod 777 tmp");
	$title = mysql_real_escape_string($_POST["title"]);
	$timelimit = mysql_real_escape_string($_POST["timelimit"]);
    $contest_id = mysql_real_escape_string($_POST["contest_id"]);
        
 $res = mysql_query("SELECT id FROM contests WHERE id='$contest_id' AND teacher_id='$user_id'");
 if(mysql_num_rows($res)==0)exit('1');	
$status = 0;

$sc=0;
if($_POST["ch_script"]=="on"){
	$sc = 1;
$file_name = $_FILES["script_file"]["name"];
$file_tmp = $_FILES["script_file"]["tmp_name"];
$status = compile_script($file_name,$file_tmp);
	}
if ($status !=0){
	exec("rm tmp/*");
	exit('3');
}
if($_POST["ch_test"]=="on"){
$file_name = $_FILES["zip_file"]["name"];
$file_tmp = $_FILES["zip_file"]["tmp_name"];
 $status =  unzip($file_name,$file_tmp,$sc);
 $zip=1;
}
if($status !=0){
	exec("rm tmp/*");
	exit('2');
}	
settype($timelimit, "float");
if($timelimit ==0) exit('4');
if($title=='') exit('5');
$dir = "/home/ubuntu/teamcode";
mysql_query("INSERT INTO problems (title,timelimit,teacher_id,script,contest_id) 
	VALUES ('$title','$timelimit','$user_id','$sc','$contest_id')");
$id = mysql_insert_id();
exec("mkdir ".$dir."/contests/".$contest_id."/".$id."/");
exec("chmod 777 ".$dir."/contests/".$contest_id."/".$id."/");
if($zip==1){

$num =  (count(glob("tmp/*"))-$sc);
if($sc==0)$num/=2;
$a = array_fill(1, $num, 0);
$info = json_encode($a);
exec("chmod -R 777 ".$dir."/contests/".$id);
for($i=1;$i<=$num;$i++) {
	copy("tmp/".$i.".in",$dir."/contests/".$contest_id."/".$id."/".$i.".in");
	exec("dos2unix ".$dir."/contests/".$contest_id."/".$id."/".$i.".in");
	if($sc==0){
copy("tmp/".$i.".ok",$dir."/contests/".$contest_id."/".$id."/".$i.".ok");
exec("dos2unix ".$dir."/contests/".$contest_id."/".$id."/".$i.".ok");
	
}
}
}
if($sc == 1){
	copy("tmp/file",$dir."/contests/".$contest_id."/".$id."/script");
}
	mysql_query("UPDATE problems SET testcases='$num', test_info='$info' WHERE id='$id'");
exec("rm tmp/*");
exec("chmod -R 777 ".$dir."/contests/".$contest_id."/".$id);
echo '0';




?>