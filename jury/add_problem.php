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
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  var n=0;
$("#ch_test").click(function(){
  $(".zip").toggle("fast");
})
$("#ch_script").click(function(){
  $(".script").toggle("fast");
})
///////////
$("#go").click(function(){$("#res").text("Loading...");})
  $('#add_problem1').ajaxForm(function(data) { 
              var res = '';
              if(data=='1') res='Invalid contest.';
              if(data=='2') res='Invalid testcases.';
              if(data=='3') res='Invalid script.';
              if(data=='4') res='Invalid timelimit.';
              if(data=='5') res='Invalid title.';
              if(data=='0') { res="Ok.";window.location='problems.php'; }
              $("#res").text(res);  
            }); 
			$("#res").text(res);  $("#res").text(res);  
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
$data = json_decode(get_user_info($_SESSION["user_id"],'teacher'));
$user_id = $data->id;

?>
<h3><p style="color:#ccc">Add problem:</p></h3>
<form id="add_problem" action="add_problem_check.php" method="post" enctype="multipart/form-data">
  <table class="std_table" >
  <tr>
    <td>Title:</td><td><input type="text" id="title" name="title"></td>
  </tr>
  <tr>
    <td>Contest:</td><td><select id="contest" name="contest_id">
<?
if($data->class!=0)
$r = mysql_query("SELECT title,id FROM contests WHERE teacher_id='$user_id'");
else $r= mysql_query("SELECT id,title FROM contests");
if(mysql_num_rows($r)>0){
 $m = mysql_fetch_assoc($r);
do{
echo "<option value='$m[id]'>$m[title]</option>";
}while($m=mysql_fetch_assoc($r));
}
?>
  </select></td>
    </tr>
   
 <tr>
    <td>Timelimit:</td><td><input type="text" id="timelimit" name="timelimit"> </td>
</tr>
 <tr>
    <td>Testcases: </td><td><input type="checkbox" id="ch_test" name="ch_test"></td>
</tr>

 <tr >
  
    <td><div class="zip" style="display:none">Zip file:</td></td>
    <td><div class="zip" style="display:none"><input type="file" id="zip-file" name="zip_file"></div></td>

</tr>
<tr>
    <td>Special script: </td><td><input type="checkbox" id="ch_script" name="ch_script"></td>
</tr>

 <tr >
  
    <td><div class="script" style="display:none">Script file:</td></td>
    <td><div class="script" style="display:none"><input type="file" id="script-file" name="script_file"></div></td>

</tr>
 
<tr>
<td><button id="go">Submit problem</button></td><td><div id="res" style="color:red; font-weight:bold; "></div></td>
  </tr>
</table>
</form>

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