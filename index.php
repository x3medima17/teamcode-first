<?
session_start();
include ("lib/fx.php");
include("lib/user_ui.php");
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
$("#intro_login").show();



$("#right_intro").click(function(){
$("#intro_login").hide("fast");
$("#show_login").show("fast");
})
$("#left_intro").click(function(){
$("#intro_login").hide("fast");
$("#choose_intro").show("fast");

})
/////////////
$("#left_choose").click(function(){
$("#choose_intro").hide("fast");
$("#signup_teacher").show("fast");
})
$("#right_choose").click(function(){
$("#choose_intro").hide("fast");
$("#signup_student").show("fast"); 
})
/////////////
$(".signup_input_teacher").blur(function(){
  var input = $(this).attr("id");
  var val = $(this).val();
  var pass = $("#teacher_pass").val();
  var fill= "#signup_"+input+"_check";
$.post("lib/signup_check.php",{type:"teacher",input:input,val:val,pass:pass},function(data){
 $(fill).attr('v',data);
 if(data=='0')
  $(fill).html("<img src=images/true.png width=18px height=18px>");
 else $(fill).html("<img src=images/false.png width=18px height=18px>");
});
})
$("#singup_teacher_go").click(function(){
var n=0; 
$(".ch_teacher").each(function(){
n= Number(n)+Number($(this).attr('v'));

})

var login = $("#teacher_login").val();
var name = $("#teacher_name").val();
var surname = $("#teacher_surname").val();
var pass = $("#teacher_pass").val();
var email = $("#teacher_email").val();
var tel = $("#teacher_tel").val();
  $.post("lib/signup.php",{type:"teacher",login:login,name:name,surname:surname,pass:pass,email:email,tel:tel},function(data){
if(data =='Your request has been sent.') {  $("#signup_res").css("color","green"); }
$("#signup_res").html(data);

  })
})
/////////////////////////
$(".signup_input_student").blur(function(){
  var input = $(this).attr("id");
  var val = $(this).val();
  var pass = $("#student_pass").val();
  var fill= "#signup_"+input+"_check";
$.post("lib/signup_check.php",{type:"student",input:input,val:val,pass:pass},function(data){
 $(fill).attr('v',data);
 if(data=='0')
  $(fill).html("<img src=images/true.png width=18px height=18px>");
 else $(fill).html("<img src=images/false.png width=18px height=18px>");
});
})
//////////////
$("#singup_student_go").click(function(){
var n=0; 
$(".ch_student").each(function(){
n= Number(n)+Number($(this).attr('v'));

})

var login = $("#student_login").val();
var name = $("#student_name").val();
var surname = $("#student_surname").val();
var pass = $("#student_pass").val();
var email = $("#student_email").val();
var teacher = $("#student_teacher").val();
var school = $("#student_school").val();
  $.post("lib/signup.php",{type:"student",login:login,name:name,surname:surname,pass:pass,email:email,teacher:teacher,school:school},function(data){
if(data =='Signup OK.<br> Now you can <a href=index.php>Login</a>') {  $("#signup_res_student").css("color","green"); }
$("#signup_res_student").html(data);

  })
})

$("#go_login").click(function(){
var login = $("#login").val();
var pass=$("#pass").val();
var type = $("#type").val()
$.post("lib/login.php",{login:login,pass:pass,type:type},function(data){
if(data!='0')
$("#result").html("<p style='color:red'>"+login+pass+type+"</p>");
else if (type=='student')window.location='index.php';
else window.location='jury/index.php';
})

})

////////////////////
$("#go").click(function(){$("#res").text("Loading...");})
  $('#uploa1d').ajaxForm(function(data) { 
if(data=='0')window.location='index.php';
else
$("#res").text("Failed.");
  })


$("#question_div").hide();

$("#ask_button").click(function(){
$("#question_div").show("fast");
})

$("#ask").click(function(){
var text = $("#text").val();
var contest_id = $("#contest_id").val();
$.post("ask.php",{text:text,contest_id:contest_id},function(data){
  $("#question_div").hide("fast");
  $("#text").val("");
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

<? if($_SESSION["type"]=="student"){
$data = json_decode(get_user_info($_SESSION["user_id"],"student"));
$user_id = $data->id;
$teacher_id = $data->teacher_id;
$login = $data->login;
$pass = $data->pass;
 ?>        
 <ul>
                <li><a href="index.php" class="selected">Home</a></li>          
                  <li><a href="rules.php">Rules</a></li>
            <li><a href="problems.php">Problems</a>
                   
                </li>
                <?
$res = mysql_query("SELECT * FROM jury WHERE login='$login' AND pass='$pass' AND active='1'");
if(mysql_num_rows($res)!=0) echo "<li><a href='switch.php'>Switch type</a></li>"
                ?>
              <li><a href="logout.php">Logout</a>
                   
                </li>
    
              
            </ul>
<? } ?>
            <br style="clear: left" />
            </div>
        </div> <!-- end of templatemo_menu -->
    </div> <!-- end of header -->
    <?
if (user_auth("student")==1) {
  show_intro();
  show_login();
  choose_intro();
  show_signup_teacher();
  show_signup_student();
exit();
}
$data = json_decode(get_user_info($_SESSION["user_id"],"student"));
$user_id = $data->id;
$teacher_id = $data->teacher_id;
$login = $data->login;
$pass = $data->pass;
?> 
   

    <div id="templatemo_main" style="width:100%">

 <div style="width:100%; ">  <p align="center"> <img align="center" src="images/teamb2.png" /></p>
  <p align=center style="color:#FFF; font-size:20px;">Welcome <b><?=$data->name." ".$data->surname; ?></b></h3></p></div>

<table width=100% border=0><tr>
<td valign=top style="padding-top:15px;">

<div id=\"submitlist\">


<div style='background-image:url(images/bar.png); width:500px; height:26px; position:relative'>
   <div style='position:relative; top:3px; left:10px;'>
     <h5  style='color:#FFF; font-family:Verdana, Geneva, sans-serif; font-variant:small-caps; font-size:15px; font-weight:bold; '>
       Send solution
     </h5>
    </div>
</div>
</div><div style='background-image:url(images/trans.png); width:420px; margin-top:0px; padding:10px '><div >

<div id='upload_box'>
  <?
      date_default_timezone_set("Europe/Chisinau");
$cid=0;
$data= json_decode(get_active_contest($teacher_id));
if($data->status ==0 ){
  $cid = $data->data->id;
$start = date("Y-m-d G:i:s",$data->data->start);
$end = date("Y-m-d G:i:s",$data->data->end);
echo "Contest name: <span style='color:#FFF'>".$data->data->title."</span><br>
Start time: <span style='color:#FFF'>$start</span><br>
End time: <span style='color:#FFF'>$end</span><br>
";


$res = mysql_query("SELECT * FROM problems WHERE contest_id='$cid'");
if(mysql_num_rows($res)==0) echo "There are no problems.";
else{
$row = mysql_fetch_assoc($res);
?>
<form id="upload" action="lib/upload_submission.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="contest_id" value="<?=$cid?>">
  <input type="hidden" name="secret" value="<?=generate_secret($user_id)?>">
Source: <input type="file" name="file"><br>
<table width="100%"><tr><td width="20%">
Problem: <select name="problem_id">
<?
do{
?>
<option value="<?=$row['id']?>"><?=$row['title']?></option>
<?
} while($row=mysql_fetch_assoc($res));
?>
</select></td><td width="7%">
<button id="go">Submit</button></td><td width="30%"><div id="res" style="color:red; font-weight:bold; width:10px; "></div></td>
</tr></table>
</form>
<?
}
}else{echo "There are no active contests.";}
  ?>
</div>
</td>
<td valign=top style="padding-top:15px;">

<div style='background-image:url(images/bar.png); width:500px; height:26px; position:relative'>
   <div style='position:relative; top:3px; left:10px;'>
     <h5  style='color:#FFF; font-family:Verdana, Geneva, sans-serif; font-variant:small-caps; font-size:15px; font-weight:bold; '>
       Clarifications
     </h5>

    </div>
</div>
</div>
<!-- <div style='background-image:url(images/trans.png); width:420px; margin-top:0px; padding:10px '>
<?
if($cid!=0){
$res = mysql_query("SELECT * FROM clarifications WHERE contest_id='$cid'");
if(mysql_num_rows($res)!=0){
$row = mysql_fetch_assoc($res);
do{
echo "<p><span style='color:#ccc;margin:3px;font-size:16px;'>• ".$row['text']."</span></p>";
}while($row = mysql_fetch_assoc($res));

}else echo"There are no clarifications.";
}else echo"There are no active contests.";


?>
</div>
-->
</td>
</tr>
<tr>
<td valign=top style="padding-top:15px;">
<div style='background-image:url(images/bar.png); width:500px; height:26px; position:relative'>
   <div style='position:relative; top:3px; left:10px;'>
     <h5  style='color:#FFF; font-family:Verdana, Geneva, sans-serif; font-variant:small-caps; font-size:15px; font-weight:bold; '>
       Submissions
     </h5>
    </div>
</div>
</div><div style='background-image:url(images/trans.png); width:420px; margin-top:0px; padding:10px '>
<?
if($cid!=0){
$res = mysql_query("SELECT * FROM submissions WHERE contest_id='$cid' AND user_id='$user_id' ORDER by time DESC");
if(mysql_num_rows($res)!=0){
  $row = mysql_fetch_assoc($res);
?>
<table width=100% style='border-bottom:1px solid #fff' ><tr style='font-size:16px; font-weight:bold; color:#DFDFDF; '>
<td width="12%">Time</td>
<td width="20%">Problem</td>
<td width="10%">Lang</td>
<td width="40%">Result</td></tr>
</table>
<table width=100% style='border-bottom:1px solid #fff' >
<?
do{ 
?>
<tr style='font-size:16px; font-weight:bold; color:#DFDFDF; '>
<td width="10%">
<?
$time = date("G:i",$row["time"]);
echo $time;
?>
</td>
<td width="20%">
  <?
  $data = json_decode(get_problem_info2($row["problem_id"]));
echo $data->title;
?>
</td>
<td width="10%"><?=$row['lang']?></td>
<?
if($row['result']=='') { 
?>
<td width="40%">Loading...</td></tr>
<?
}
elseif($row['result']=='Correct'){
  ?>
<td width="40%"><span style="color:green;">Correct</span></td></tr>

  <?
}
else{
  ?>
<td width="40%"><span style="color:red;"><?=$row['result']?></span></td></tr>

  <?
}
?>

<?
}while($row=mysql_fetch_assoc($res));
echo "</table>";
} else echo"There are no submissions.";
 } else echo "There are no active contest."; ?>
<div >

 </div></div>
</td>
<td valign=top style="padding-top:15px;">

<div style='background-image:url(images/bar.png); width:500px; height:26px; position:relative'>
   <div style='position:relative; top:3px; left:10px;'>
     <h5  style='color:#FFF; font-family:Verdana, Geneva, sans-serif; font-variant:small-caps; font-size:15px; font-weight:bold; '>
       Questions
     </h5>
    </div>
</div>
</div>
<!--
<div style='background-image:url(images/trans.png); width:420px; margin-top:0px; padding:10px '>


<?
if($cid!=0){
?>
<button id='ask_button'>Ask a question</button>
<div id='question_div'>
<textarea id='text'>
</textarea>
<input type="hidden" id="contest_id" value=<?=$cid?>>
<br>
<button id='ask'>Ask</button>
</div><br>
<?
$res = mysql_query("SELECT * FROM questions WHERE contest_id='$cid' AND user_id='$user_id' AND answer!=''");
if(mysql_num_rows($res)!=0){
$row = mysql_fetch_assoc($res);
do{
echo "<p><span style='color:#ccc;margin:3px;font-size:16px;'>• ".$row['text']."</span></p>";
}while($row = mysql_fetch_assoc($res));

}else echo"There are no questions.";
}else echo"There are no active contests.";


?>

<div >
-->


 </div></div>
</td>
</tr>

</table>

        </div>
  
    </div> <!-- end of main --><!-- end of wrapper -->
    
    <style>

.footw {
  position:absolute !important;
  bottom: 1px;
  margin-bottom: 0px !important;
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