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
  $("#go").click(function(){
   
    var title= $("#title").val();
    var start= $("#start").val();
    var end= $("#end").val();
    var contest_id = $("#contest_id").val();
    //alert(contest_id);
    $.post("edit_contest_check.php",{title:title,start:start,end:end,cid:contest_id},function(data){
        if(data=='0'){
        window.location="contests.php";
        //    alert(data);
        }
        else $("#res").text("Update failed");
       //$("#res").text(data);
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
$data = json_decode(get_user_info($_SESSION["id"],"teacher"));
$id = $data->id;

}
?>
<?
$id = mysql_real_escape_string($_GET['id']);
$action = mysql_real_escape_string($_GET["action"]);
$user_id= $_SESSION["user_id"];
$data = json_decode(get_user_info($user_id,"teacher"));
$status =0;
$user_id = $data->id;
$class = $data->class;

if($class!=0){
$res = mysql_query("SELECT * FROM contests WHERE id='$id' AND teacher_id='$user_id'");

}else $res=mysql_query("SELECT * FROM contests WHERE id='$id'");
if(mysql_num_rows($res)==0)header("Location:contests.php");

if($action=="delete"){
delete_contest($id);
}
if($action=="edit"){
    date_default_timezone_set("Europe/Chisinau");
$row = mysql_fetch_array($res);
$start = date("Y-m-d G:i:s",$row["start"]);
$end = date("Y-m-d G:i:s",$row["end"]);

?>

<table class="std_table" >
  <tr>
    <input type="hidden" value="<?=$id?>" id="contest_id">
    <td>Title:</td><td><input type="text" id="title" value="<?=$row['title']?>"></td>
  </tr>
  <tr>
    <td>Start time:</td><td><input type="text" id="start" value="<?=$start?>"> (YYYY-MM-DD HH:MM:SS)</td>
    </tr>
    <tr>
    <td>End time:</td><td><input type="text" id="end" value="<?=$end?>"> (YYYY-MM-DD HH:MM:SS)</td>
</tr>
<tr>
<td><button id="go">Submit contest</button></td><td><div id="res" style="color:red; font-weight:bold; "></div></td>
  </tr>
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