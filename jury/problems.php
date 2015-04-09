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

<button onclick="window.location='add_problem.php'">Add problem</button>
<br><br>
<?
if(isset($_GET["contest_id"])){
$contest_id= mysql_real_escape_string($_GET["contest_id"]);

if($data->class==0)
$res = mysql_query("SELECT * FROM problems WHERE contest_id = '$contest_id'");
else $res = mysql_query("SELECT * FROM problems WHERE teacher_id='$user_id' AND contest_id = '$contest_id' ");
}
else{
  if($data->class==0)
$res = mysql_query("SELECT * FROM problems ");
else $res = mysql_query("SELECT * FROM problems WHERE teacher_id='$user_id' ");  
}
if(mysql_num_rows($res)>0) {
?>
<table class="maintable1" width="100%">
  <tr>
<th width="20%">Problem name</th>
<th width="20%">Contest</th>
<th  width="20%">Timelimit</th>
<th width="10%">Testcases</th>
<th  width="60%">Submissions</th>
<th>Edit</th><th>Delete</th>
</tr>
<?


$row = mysql_fetch_assoc($res);
do{
    $cid = $row["contest_id"];
    $pid = $row["id"];
    $r1 = mysql_query("SELECT title FROM contests WHERE id='$cid'");
    $r = mysql_fetch_assoc($r1);
    $s = mysql_query("SELECT id FROM submissions WHERE problem_id='$pid' ");
    $sub = mysql_num_rows($s);
   
?>
<tr>
<td class="problems_td" onclick="window.location='edit_problem.php?problem_id=<?=$pid?>&action=edit'"><?=$row["title"]?></td>
<td class="problems_td" onclick="window.location='problems.php?contest_id=<?=$cid?>'"><?=$r["title"]?></td>
<td class="problems_td"><?=$row["timelimit"]?></td>
<td class="problems_td" onclick="window.location='testcases.php?problem_id=<?=$pid?>'"><?=$row["testcases"]?></td>
<td class="problems_td" onclick="window.location='submissions.php?problem_id=<?=$pid?>'"><?=$sub?></td>
<td><a href="edit_problem.php?problem_id=<?=$pid?>&action=edit"><img src="images/edit.png" width="24px" height="24px"></a></td>
<td><a href="edit_problem.php?problem_id=<?=$pid?>&action=delete"><img src="images/delete.png" width="24px" height="24px"></a></td>
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