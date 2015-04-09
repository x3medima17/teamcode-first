<?

function generate_secret($user_id){
  $key = 17;
  return base64_encode(base64_encode(($user_id*$key)*($user_id*$key)));
}
function db_conn(){
$server = "localhost";
$user = "root";
$pass = "salapia";
$db_name = "teamcode";	
$db = mysql_connect($server,$user,$pass);
mysql_select_db($db_name);

}

function user_auth($type1){
	db_conn();

if(!isset($_SESSION["user_id"]) || !isset($_SESSION["type"])){
$result =1;
} 
else {

	$user_id=$_SESSION["user_id"];
	$type = $_SESSION["type"];
	$key= $_SESSION["key"];
	if($type=='student')
	$res = mysql_query("SELECT id FROM users WHERE id='$user_id' AND accesskey='$key'");
   elseif($type=='teacher') 	
	$res = mysql_query("SELECT id FROM jury WHERE id='$user_id' AND accesskey='$key'") or die(mysql_error());
  if(mysql_num_rows($res)==0) $result=1;
  if ($type!=$type1) $result=1;
  else
$result = 0;
}
if($result!=0){
unset($_SESSION["user_id"]);
unset($_SESSION["type"]);
unset($_SESSION["key"]);

}
return $result;
}
function get_user_info($user_id,$type){
if ($type=='student')
$res = mysql_query("SELECT * FROM users WHERE id='$user_id'");
else $res = mysql_query("SELECT * FROM jury WHERE id='$user_id'");
$row = mysql_fetch_assoc($res);
return json_encode($row);
}
function login($login,$pass,$type){
	if(!$_SESSION){ 
  $login = mysql_real_escape_string($login);
  $pass = mysql_real_escape_string($pass);
if($type=="student")
                    $res = mysql_query("SELECT * FROM users WHERE login='$login' AND pass='$pass'");
elseif ($type=='teacher')
	           $res = mysql_query("SELECT * FROM jury WHERE login='$login' AND pass='$pass' AND active='1'");
if (mysql_num_rows($res)!=0) {
    	$row = mysql_fetch_array($res);
    	$key = md5(md5(rand(1,10000)).md5(rand(1,15645)));
	$_SESSION["user_id"]=$row["id"];
	$_SESSION["type"]=$type;
    $_SESSION["key"]=$key;
if($type=="student")
                    mysql_query("UPDATE users SET accesskey='$key' WHERE login='$login' AND pass='$pass'") or die(mysql_error());
elseif ($type=='teacher')
                         mysql_query("UPDATE jury SET accesskey='$key' WHERE login='$login' AND pass='$pass'") or die(mysql_error()); 

	$data = array("status"=>0,"data"=>get_user_info($row["id"],$type));	
}
else $data = array("status"=>1);
}
else $data = array("status"=>1);

return json_encode($data);
}
	function count_p($id){
		$res = mysql_query("SELECT id from problems WHERE contest_id='$id'");
		return mysql_num_rows($res);
	}
//////////////////////////


 //////////////////////
function delete_contest($id){
    $res = mysql_query("SELECT * FROM submissions WHERE contest_id='$id'");
    if(mysql_num_rows($res)>0){
    $row = mysql_fetch_assoc($res);
do{
    $user_id = $row['user_id'];
    $sid = $row["id"];
    $lang = $row["lang"];
exec("rm ../upload/$user_id/$sid.$lang");
mysql_query("DELETE FROM judge WHERE submission_id='$sid'");
}while($row = mysql_fetch_assoc($res));
}
exec("rm -rf ../contests/$id");
mysql_query("DELETE FROM submissions WHERE contest_id='$id'");
mysql_query("DELETE FROM problems WHERE contest_id='$id'");
mysql_query("DELETE FROM contests WHERE id='$id'");
fail("contests.php");
}

function fail($to){
    header("Location:".$to);
}


function unzip($file_name,$file,$sc){
$ext = explode(".",$file_name);
$ext = end($ext);
if($ext!='zip') return '1';
exec("chmod -R 777 tmp/");
 move_uploaded_file($file,"tmp/file.zip");
exec("unzip tmp/file.zip -d tmp/");
exec("rm tmp/file.zip");
$num =  count(glob("tmp/*"))-$sc;
if($sc==0) $num/=2;

for($i=1;$i<=$num;$i++) {
if($sc==0){
    if(!file_exists("tmp/".$i.".in") || !file_exists("tmp/".$i.".ok")) return '3';
 }else  if(!file_exists("tmp/".$i.".in")) return '3';
 }
 exec("chmod -R 777 tmp/");
   
    return '0';
}

function compile_script($file_name,$file){
$ext = explode(".",$file_name);
$ext = end($ext);
if($ext !='c' && $ext!='cpp' && $ext !='pas') return '1';
 move_uploaded_file($file,"file.".$ext);
 if(validate_script("file.".$ext)!=0) return '2';
exec("chmod  777 file.pas");
switch ($ext){
case "pas": 
exec("fpc file.pas",$out);
if(file_exists('file.pas'))unlink('file.pas');
if(file_exists('file.o'))unlink('file.o');
if(!file_exists("file")) return '3';
copy("file","tmp/file");
unlink("file");

exec("chmod -R 777 tmp");
break;

default: 
exec("g++ -Wall -pedantic -o file file.".$ext);
if(!file_exists("file")) return '3';
copy("file","tmp/file");
unlink("file");
exec("chmod -R 777 tmp");
unlink("file.".$ext);
}

}


function validate_script($file){
    $data = file_get_contents($file);
    $sec = array("shell","exec","system","#asm");
    str_replace($sec,"",$data,$c);
    return $c;
}

function delete_problem($id){
$res = mysql_query("SELECT * FROM problems WHERE id='$id'");
$row = mysql_fetch_assoc($res);
$cid = $row["contest_id"];
mysql_query("DELETE FROM problems WHERE id='$id'");
exec("rm -rf ../contests/$cid/$id");
$res = mysql_query("SELECT * FROM submissions WHERE problem_id='$id'");
if(mysql_num_rows($res)>0){
$row = mysql_fetch_assoc($res);
do {
$user = $row["user_id"];
$lang = $row["lang"];
$sid = $row["id"];
mysql_query("DELETE FROM judge WHERE submission_id='$sid'");
exec("rm ../upload/$user/$sid.$lang");
}while($row = mysql_fetch_assoc($res));
mysql_query("DELETE FROM submissions WHERE problem_id='$id'");
}
fail("problems.php");
}

function get_active_contest($teacher_id){
  $time = time();
  
$res = mysql_query("SELECT * FROM contests WHERE teacher_id='$teacher_id' AND start<='$time' AND end>='$time' LIMIT 1");
if(mysql_num_rows($res)==0){ $data = array("status"=>1); return json_encode($data);}

$row = mysql_fetch_assoc($res);
$contest_data = $row;
$data = array("status"=>0,"data"=>$contest_data);
return json_encode($data);
}

function validate_upload_time($time,$id){
  $res = mysql_query("SELECT * FROM contests WHERE id='$id'");
  if(mysql_num_rows($res)==0) return('1');
  $row = mysql_fetch_assoc($res);
  $start = $row["start"];
  $end = $row["end"];
  if($time<$start || $time>$end) return('2');
  return('0');
}

function get_problem_info2($id){
$res = mysql_query("SELECT * FROM problems WHERE id='$id'");
if(mysql_num_rows($res)==0) return;
$row = mysql_fetch_assoc($res);
return json_encode($row);
}

function get_contest_info($id){
$res = mysql_query("SELECT * FROM contests WHERE id='$id'");
if(mysql_num_rows($res)==0) return;
$row = mysql_fetch_assoc($res);
return json_encode($row);
}

function get_problem_list($id){
$res = mysql_query("SELECT * FROM problems WHERE contest_id='$id'");
if(mysql_num_rows($res)==0) return '{}';
$row = mysql_fetch_assoc($res);
$a = array();
do{
array_push($a, $row);
}while($row=mysql_fetch_assoc($res));
return json_encode($a);
}

function count_user_score($user_id,$problem_id){
  $res = mysql_query("SELECT total FROM submissions WHERE user_id='$user_id' AND problem_id='$problem_id' ORDER by id DESC LIMIT 1");
  if(mysql_num_rows($res)==0)return '0';
  $row = mysql_fetch_assoc($res);
$n = $row["total"];
  return "$n";
}
?>