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

$user_id=$data->id;

if(!$_GET['contest_id']) fail("index.php");
$contest_id = mysql_real_escape_string($_GET["contest_id"]);
$res = mysql_query("SELECT * FROM users WHERE teacher_id='$user_id'");
if(mysql_num_rows($res)>0) {
    $row = mysql_fetch_assoc($res);
$problems = json_decode(get_problem_list($contest_id));
$n = count($problems);
$w = ($n)*5+25;

?>
<table class="maintable1" width="<?=$w?>%">
  <tr>
<th width="15%">Student</th>
<?

foreach($problems as $val) echo "<th width='5%'>$val->title</th>";
?>
<th width="10%">Total</th>
</tr>
<?
do{
    $total = 0;
    $user_data = json_decode(get_user_info($row['id'],"student"));
?>
<td><?=$user_data->name?> <?=$user_data->surname?></td>
<?
foreach($problems as $val){
$curr = count_user_score($user_data->id,$val->id);
$total +=$curr;
echo "<td>$curr</td>";
} 
echo "<td>$total</td>";
}while($row=mysql_fetch_assoc($res));
?>
</table>
<? } else echo "<h3><p style='color:#ccc'>There are no students</p></h3>";
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