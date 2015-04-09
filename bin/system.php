#!/usr/bin/env php
<?
echo "Starting system";
usleep(500000); echo "."; usleep(500000); echo "."; usleep(500000); echo ".";usleep(500000);  echo "\n";

echo "System has been started. \n";
sleep(1);
echo "Waiting for new submissions... \n";

/////////////////////
include("../lib/fx.php");
include("functions.php");
db_conn();
$results = array("Correct",'Submission Failed','Compile error','Timelimit exceeded','No output file','Wrong answer');
while(1){
	$time=0;
	sleep(2);
$res = mysql_query("SELECT * FROM submissions WHERE result='' LIMIT 1") or die(mysql_error());
if(mysql_num_rows($res)!=0) {
	$row = mysql_fetch_assoc($res);
	$id = $row["id"];
	$user_id = $row["user_id"];
	$problem_id = $row["problem_id"];
	$contest_id = $row["contest_id"];
	$lang = $row["lang"];
    $status = 0;


$data = json_decode(get_problem_info($problem_id));
    $title = $data->title;
    $timelimit = $data->timelimit;
    $ext_time = round($timelimit)+1;
    $n = $data->testcases;
    $sc = $data->script;
    $info = json_decode($data->test_info);

/////////////////////////////////////////////////////////////////////////
$res = copy_source($id,$lang,$user_id);
	if($res =='1'){
   echo "error\n";
   insert_res($id,$results[1],$n,0,$time);
   calc($id,$problem_id);

   continue;
	}

$res = compile($lang);
	if($res =='1'){
   insert_res($id,$results[2],$n,0,$time);
   calc($id,$problem_id);
   continue;
	}

if($sc=='0')
    for($i=1;$i<=$n;$i++){
    $val = $info->{$i};
	copy_testcase($contest_id,$problem_id,$i,$title);
	$start_time = get_curr_time();
	exec("timeout $ext_time ./file",$retval);
	$end_time = get_curr_time();
	$time = $end_time-$start_time;
	$time = round($time,3);
      if($retval == 124 || $time>$timelimit) { 
		insert_res($id,$results[3],0,$i,$time); 
	unlink($title.".in");
	unlink($title.".ok");
	continue;
	}

if(!file_exists($title.".out")){
	insert_res($id,$results[4],0,$i,$time); 
	unlink($title.".in");
	unlink($title.".ok");
	continue;
}	

	$target = $title.".out";
	$test = $title.".ok";

	$crc_target = strtoupper(dechex(crc32(file_get_contents($target))));
	$crc_test = strtoupper(dechex(crc32(file_get_contents($test))));

	$user_data = file_get_contents($target);
	$test_data = file_get_contents($test);
echo "\n $user_data    $test_data  \n";

if($crc_target!=$crc_test){
	insert_res($id,$results[5],0,$i,$time); 
	unlink($title.".in");
	unlink($title.".ok");
	unlink($title.".out");
	continue;
}	
	insert_res($id,$results[0],0,$i,$time); 
	unlink($title.".in");
	unlink($title.".ok");
	unlink($title.".out");
   } 
    elseif($sc=='1'){
///////////// Copy script ////////////////
  	copy("../contests/$contest_id/$problem_id/script",'script');
exec("chmod 777 script");
///////////////// Run testcases ///////////
  	for($i=1;$i<=$n;$i++){
  		$time = 0;
  		$val = $info->{$i};
  		copy("../contests/$contest_id/$problem_id/$i.in","$title.in");
  		$start_time = get_curr_time();
  		exec("timeout $ext_time ./file",$retval);
  			$end_time = get_curr_time();
  			$time = $end_time-$start_time;
	       $time = round($time,3);
	        if($retval == 124 || $time>$timelimit) { 
		insert_res($id,$results[3],0,$i,$time); 
	unlink($title.".in");
	
	continue;
	}

if(!file_exists($title.".out")){
	insert_res($id,$results[4],0,$i,$time); 
	unlink($title.".in");
	continue;
}
    exec("timeout 5 ./script",$out,$retval);

    if(end($out)!='TRUE'){
    		insert_res($id,$results[5],0,$i,$time); 
	unlink($title.".in");
	unlink($title.".out");
	continue;
    }
    insert_res($id,$results[0],0,$i,$time); 
	unlink($title.".in");
	unlink($title.".out");
   } 

  	}/////////////////





   
  unlink("file"); unlink("file.$lang"); unlink("file.o"); 
  if(file_exists('script')) unlink('script');
  calc($id,$problem_id,$n);
}}
?>
