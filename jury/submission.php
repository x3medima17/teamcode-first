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
fail("index.php");
exit();
}
$data = json_decode(get_user_info($_SESSION["user_id"],'teacher'));
$user_id = $data->id;
if(!$_GET["id"]) fail("index.php");
$id = mysql_real_escape_string($_GET["id"]);
$res = mysql_query("SELECT * FROM judge WHERE submission_id='$id' ORDER by id ");
if(mysql_num_rows($res)!=0){
$row = mysql_fetch_assoc($res);

?>
<table class="maintable1" width="30%">
  <tr>
<th width="5%">#</th>
<th width="5%">Runtime</th>
<th  width="5%">Score</th>
<th  width="20%">Result</th>
</tr>
<?
do{
  $i++;
?>
<tr>
<td><?=$i?></td>
<td><?=$row["time"]?></td>
<td><?
$r1 = mysql_query("SELECT judge.submission_id, submissions.problem_id,problems.test_info FROM judge 
  INNER JOIN submissions INNER JOIN problems WHERE submissions.id='$id' AND problems.id=submissions.problem_id LIMIT 1");
$r = mysql_fetch_assoc($r1);
$data_test = json_decode($r["test_info"]);
echo $data_test->{$i};

?></td>
<td>
<?
$result = $row["result"];
if($result == '') { $color="#ccc"; $result="Loading.."; }
elseif($result == 'Correct') $color="green"; 
else $color="red"; 
echo "<span style='color:$color'>$result</span>";
?>
  </td>
</tr>
<?
}while($row= mysql_fetch_assoc($res));
?>
</table>
<?
}
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