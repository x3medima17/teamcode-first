<?
session_start();
include ("../lib/fx.php");
include("../lib/user_ui.php");
db_conn();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teamcode</title>
<meta name="keywords" content="graphite theme, professional, free templates, CSS, HTML" />
<meta name="description" content="Graphite Theme, professional free CSS template from templatemo.com website" />
<link href="css/templatemo_style.css" rel="stylesheet" type="text/css" />




<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<link rel="stylesheet" type="text/css" href="css/ui.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  $(".rejudge").click(function(){
    var id = $(this).attr("id");
    $.post("rejudge.php",{id:id},function(data){
       if(data=='0') window.location='submission.php?id='+id;
    })

  })
})


</script>


  
</head>
<body id="home">
<div id="bg">

<div id="templatemo_wrapper">
<!-- end of top -->

  	<div id="templatemo_header"  >
        <div id="navbar">
    	<div id="site_title"><h1><a href="index.php"></a></h1></div>
        <div id="templatemo_menu" class="ddsmoothmenu">
<? include("lib/header.php");?>            
<br style="clear: left" />

            </div>
        </div> <!-- end of templatemo_menu -->
    </div> <!-- end of header -->
    
   

    <div id="templatemo_main" style="width:100%">
    <?
if (user_auth("teacher")!=0) {
echo"<script>window.location='../index.php'</script>";
exit();

}
$data = json_decode(get_user_info($_SESSION["user_id"],"teacher"));
$user_id = $data->id;

?>


<?
if(isset($_GET["contest_id"])){
$contest_id= mysql_real_escape_string($_GET["contest_id"]);
$res = mysql_query("SELECT submissions.id as id,submissions.contest_id AS contest_id, submissions.id AS submission_id, 
    submissions.user_id AS user_id, submissions.result AS result, submissions.time AS time,
     submissions.lang AS lang, submissions.total AS total, submissions.problem_id AS problem_id
FROM `submissions`
INNER JOIN contests
WHERE submissions.contest_id = contests.id
AND contests.teacher_id ='$user_id'
AND contests.id='$contest_id' ORDER by time DESC");
}
elseif(isset($_GET["problem_id"])){
$problem_id= mysql_real_escape_string($_GET["problem_id"]);
    $res = mysql_query("SELECT submissions.id as id,submissions.contest_id AS contest_id, submissions.id AS submission_id, submissions.user_id AS user_id,
     submissions.result AS result, submissions.time AS time, submissions.lang AS lang, submissions.total AS total,
      submissions.problem_id AS problem_id
FROM `submissions`
INNER JOIN problems
WHERE submissions.problem_id = problems.id
AND problems.teacher_id ='$user_id'
AND problems.id='$problem_id'  ORDER by time DESC");
}
elseif(isset($_GET["student_id"])){
$student_id= mysql_real_escape_string($_GET["student_id"]);
    $res = mysql_query("SELECT submissions.id as id, submissions.contest_id AS contest_id, submissions.id AS submission_id, submissions.user_id AS user_id,
     submissions.result AS result, submissions.time AS time, submissions.lang AS lang, submissions.total AS total,
      submissions.problem_id AS problem_id
FROM `submissions`
INNER JOIN problems
WHERE submissions.user_id = usres.id
AND users.teacher_id ='$user_id'
AND users.id='$student_id'  ORDER by time DESC");
}
else{
    $res = mysql_query("SELECT submissions.id as id,submissions.contest_id AS contest_id, submissions.id AS submission_id, submissions.user_id AS user_id,
     submissions.result AS result, submissions.time AS time, submissions.lang AS lang, submissions.total AS total,
      submissions.problem_id AS problem_id
FROM `submissions`
INNER JOIN contests
WHERE submissions.contest_id = contests.id
AND contests.teacher_id ='$user_id'  ORDER by time DESC") or die(mysql_error());
}
if(mysql_num_rows($res)>0) {
?>
<table class="maintable1" width="100%">
  <tr>
<th width="20%">Time</th>
<th width="20%">Problem</th>
<th  width="20%">Contest</th>

<th  width="10%">Student</th>
<th  width="10%">Score</th>
<th  width="60%">Result</th>
<th>Rejudge</th>
<th>View</th>
</tr>
<?
      date_default_timezone_set("Europe/Chisinau");


$row = mysql_fetch_assoc($res);
do{
    $contest_id = $row["contest_id"];
    $problem_id = $row["problem_id"];
    $student_id = $row["user_id"];
    $contest_data = json_decode(get_contest_info($contest_id));
    $problem_data = json_decode(get_problem_info2($problem_id));
    $user_data = json_decode(get_user_info($student_id,"student"));
    $result = $row["result"];
?>
<tr>
<td><?=date("G:i",$row["time"])?></td>
<td class="problems_td" onclick="window.location='submissions.php?problem_id=<?=$problem_data->id?>'"><?=$problem_data->title?></td>
<td class="problems_td" onclick="window.location='submissions.php?contest_id=<?=$contest_data->id?>'"><?=$contest_data->title?></td>
<td class="problems_td" onclick="window.location='submissions.php?user_id=<?=$user_data->id?>'"><?=$user_data->name?> <?=$user_data->surname?></td>
<td><?=$row["total"]?></td>
<td>
<?
if($result == '') { $color="#ccc"; $result="Loading.."; }
elseif($result == 'Correct') $color="green"; 
else $color="red"; 
echo "<span style='color:$color'>$result</span>";
?>
    </td>
<td class="problems_td rejudge" id="<?=$row['id']?>"><img src="../images/rejudge.png" width="24px" height="24px"></td>
<td class="problems_td" onclick="window.location='submission.php?id=<?=$row['id']?>'"><img src="../images/view.png" width="24px" height="24px"></td>
</tr>
<?
}while($row = mysql_fetch_assoc($res));


?>
</table>
<? } else echo "<h3><p style='color:#ccc'>There are no problems</p></h3>";
?>

        </div>
  
    </div> <!-- end of main --><!-- end of wrapper -->
    
    <style>
.footw {
position:absolute !important;
bottom:0px !important;
}
</style>
    
<div id="templatemo_footer_wrapper" class='footw'>
    <div id="templatemo_footer">
        TeamCode © 2012 | <a href="http://moldoturc.orizont.org" target="_blank">Liceul Teoretic "Orizont"</a> 
        
        
    </div>
</div> 
  </div>
</body>
</html>