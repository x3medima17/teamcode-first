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
  $(".t").click(function(){
var id = $(this).attr("id");

$(this).hide();
$("#i"+id).show();
  })

  $(".i").blur(function(){
var val= $(this).val();
var id = $("#id").val();
var str= $(this).attr("id");
var test = str.replace("i",'');
val=Number(val);
$(this).val(val);
$.post("edit_testcase_val.php",{val:val,id:id,test:test},function(data){
if(data==0) $("#"+test).text(val);

})
$("#"+test).show();
$(this).hide();
  })

$("#go").click(function(){$("#res").text("loading");})
  $('#add_testcase').ajaxForm(function(data) {
  var idd=$("#id").val(); 
if(data!='0') $("#res").text("Error.");
else window.location='testcases.php?problem_id='+idd;
})

})


</script>


  
</head>
<body id="home" >
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
$user_id = $data->id;
$id = mysql_real_escape_string($_GET["problem_id"]);
$res = mysql_query("SELECT * FROM problems WHERE id='$id' AND teacher_id='$user_id'");
if(mysql_num_rows($res)==0) fail("index.php");
$row = mysql_fetch_assoc($res);
$n = $row["testcases"];
$sc = $row["script"];
$cid = $row["contest_id"];
$info = json_decode($row["test_info"]);
if($n>0){
?>
<button onclick="window.location='reset_testcases.php?problem_id=<?=$id?>'">Reset</button>
<br><br>
<input type="hidden" value="<?=$id?>" id="id">
<table class="maintable1" width="40%">
  <tr>
<th width="5%">#</th>
<th width="20%">Input</th>
<th  width="20%">Output</th>
<th width="15%">Value</th>
</tr>
<?
for($i=1;$i<=$n;$i++){
    $add = "../contests/$cid/$id/$i";
?>
<tr>
<td  style="height:25px;"><?=$i?></td>
<td><a href="<?=$add?>.in">Input<?=$i?></a></td>
<td><?
if($sc=='1')echo "No Output."; 
else{
?>
<a href="<?=$add?>.ok">Output<?=$i?></a>
<? } ?>
</td>
<td><span  class="t" id="<?=$i?>" style="cursor:pointer"><?=$info->{$i}?></span>
    <input class="i" id="i<?=$i?>" type="text" style="width:30px; display:none;" value="<?=$info->{$i}?>"></td>    

    </tr>
<?
}
?>
</table>
<? 
} else echo "<h3><p style='color:#ccc'>There are no testcases</p></h3>";
?>
<br><br>
<h2><p style='color:#ccc'>Add testcase:</p></h2>
<form id="add_testcase" action="add_testcase_check.php" method="post" enctype="multipart/form-data">
<table class="std_table" >
  <tr>
    <input type="hidden" name="id" value="<?=$id?>" id="id">
    <td>Input:</td><td><input type="file"  name="in"></td>
  </tr>
<? if($sc!='1') {  ?><tr>
    <td>Output:</td><td><input type="file"  name="out"></td>
  </tr>
  <? } ?>
  <tr>
    <td>Value:</td><td><input type="text"  name="value"></td>
  </tr>
  <tr>
    <td><button id="go">Submit</button></td><td><div id="res" style="color:red;"></div></td>
  </tr>
</table>

</form>

        </div>
  
    </div> <!-- end of main --><!-- end of wrapper -->
    
    <style>
.footw {
position:absolute !important;
bottom:-25px ;
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