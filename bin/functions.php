<?

function get_curr_time()
{
    list ($msec, $sec) = explode(' ', microtime());
    $microtime = (float)$msec + (float)$sec;
    return $microtime;
}

function copy_source($id,$lang,$user_id){
$res = copy("../upload/$user_id/$id.$lang", "file.$lang");
if($res == FALSE) return('1');
}

function insert_res($submission_id,$res,$n,$test,$time){
	if($test==0){
		for($i=1;$i<=$n;$i++)
        mysql_query("INSERT INTO judge (submission_id,result,test,time) VALUES ('$submission_id','$res','$i','$time')");
	}else
	mysql_query("INSERT INTO judge (submission_id,result,test,time) VALUES ('$submission_id','$res','$test','$time')");
	}

function compile($lang){
	exec("chmod 777 file.$lang");
	if($lang == "pas"){
		exec("fpc file.pas");
	}
	else{
		exec("g++ -Wall -O2 -static  -o file file.".$lang);
	}
	if(!file_exists("file")) return('1');
}

function get_problem_info($id){
	$res = mysql_query("SELECT * FROM problems WHERE id='$id'");
	$row = mysql_fetch_assoc($res);
	return json_encode($row);
}

function copy_testcase($contest_id,$problem_id,$id,$title){
copy("../contests/$contest_id/$problem_id/$id.in", "$title.in");
copy("../contests/$contest_id/$problem_id/$id.ok", "$title.ok");
}

function calc($id,$problem_id){
	$res = mysql_query("SELECT * FROM problems WHERE id='$problem_id'");
	$row = mysql_fetch_assoc($res);
	$data = json_decode($row["test_info"]);
	$example_result = 'Correct';
	$n = $row["testcases"];
	$total=0;
	for($i=1;$i<=$n;$i++){
		$val = $data->{$i};
		$res = mysql_query("SELECT * FROM judge WHERE submission_id='$id' AND test='$i'");
		$row = mysql_fetch_assoc($res);
        if($val==0 && $row["result"]!='Correct') $example_result=$row["result"];
        if($row["result"]=='Correct') $total+=$val; 
	}
	mysql_query("UPDATE submissions SET result='$example_result',total='$total' WHERE id='$id'");
}
?>