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
fail("../index.php");
exit();
}

$data = json_decode(get_user_info($_SESSION["user_id"],"teacher"));
$id = $data->id;


?>

<button onclick="window.location='add_contest.php'">Add contest</button>
<br><br>
<?
if($data->class==0)
$res = mysql_query("SELECT * FROM contests ORDER by end DESC");
else $res = mysql_query("SELECT * FROM contests WHERE teacher_id='$id' ORDER by end DESC");

if(mysql_num_rows($res)>0) {
?>
<table class="maintable1" width="100%">
  <tr>
<th width="20%">Contest name</th>
<th width="20%">Start time</th>
<th  width="20%">End time</th>
<th width="10%">Problems</th>
<th  width="60%">Time remains</th>
<th>View</th><th>Edit</th><th>Delete</th>
</tr>
<?


$row = mysql_fetch_assoc($res);
date_default_timezone_set("Europe/Chisinau");
do{
?>
<tr>
<td><?=$row["title"]?></td>
<td><?=date("Y-m-d G:i:s",$row["start"])?></td>
<td><?=date("Y-m-d G:i:s",$row["end"])?></td>
<td><?=count_p($row["id"])?></td>
<td><?
$num = $row["end"]-time();

if($num>0){
$days = intval($num/60/60/24);
$num -= 60*60*24*$days;
$hours = intval($num/60/60);
$num -= 60*60*$hours;
$min = intval($num/60);
$num -= 60*$min;
$sec = $num;

echo $days." days ".$hours." hours ".$min." minutes ".$sec." seconds.";
}
else echo "Contest finished.";
?>

</td>
<td><a href="scoreboard.php?contest_id=<?=$row['id']?>"><img src="../images/view.png" width="24px" height="24px"></a></td>
<td><a href="edit_contest.php?id=<?=$row['id']?>&action=edit"><img src="images/edit.png" width="24px" height="24px"></a></td>
<td><a href="edit_contest.php?id=<?=$row['id']?>&action=delete"><img src="images/delete.png" width="24px" height="24px"></a></td>
</tr>
<?
}while($row = mysql_fetch_assoc($res));


?>
</table>
<? } else echo "<h3><p style='color:#ccc'>There are no contests</p></h3>";
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