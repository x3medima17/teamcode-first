<?
session_start();
include ("lib/fx.php");
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

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/ddsmoothmenu.js">

/***********************************************
* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>
<script>
$(document).ready(function(){
$("#login").hide();
$("#signup").hide();
$("#signupch").hide();
$("#lg").click(function(){
$("#cho").slideUp("fast");
$("#login").slideDown("fast");
})
$("#rg").click(function(){
$("#cho").slideUp("fast");
 $("#signupch").show("fast");
$("#teacher").click(function(){
$("#signupch").hide("fast");
$("#studentreg").hide("fast");
$("#teacherreg").show("fast");

})
$("#student").click(function(){
$("#signupch").hide("fast");
$("#studentreg").show("fast");
$("#teacherreg").hide("fast");

})
})
function upload_box(){
 teacher = $("#teach").val();
$('#upload_box').load('upload_box.php',{teacher:teacher});

setTimeout(function() {upload_box();},60000);
}
upload_box();
//setTimeout(function() {upload_box();},1250); 

})

</script>
  
</head>
<body id="home">
<div id="bg">
<input type='hidden' id='teach' value=<?=$teacher?>>

<?
function auth(){
?>
<div style="margin-top:100px; width:auto; position:absolute; left:40%">
<p align=center>
<table id='cho' style="cursor:pointer;">
<tr>
<td style="border-right:1px solid #CCC; padding:5px;" id='rg'>
<h3><font color=white>Signup</font></h3>
<img src=http://cdn1.iconfinder.com/data/icons/Free-Medical-Icons-Set/128x128/Application.png>
</td>
<td style="padding:10px;" id='lg'>
<h3><font color=white>  Login</font></h3>
<img src=http://cdn1.iconfinder.com/data/icons/oxygen/128x128/apps/preferences-desktop-cryptography.png>
</td>
</tr>
</table>

<div id=login style="color:#FFF">
<h3><font color=white>Please log in</font></h3>
<form action='lib/auth.php' method=post>
Login:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=text name=login><br>
<br>Password:<input type=password name=pass><br>
<br><input type=submit value="Go">
</form>
</div>
<br>

</p>
</div>
<div id=signupch >
<?
include("sign.php");
echo "</div>";
}
if (!$_SESSION[login]) $err = "Not logged";
if ($err) exit (auth());
$title = $_SESSION[login];
include ("lib/db.php");
//include ("lib/auth.php");
//putTeamRow($cdata, array($login));

?>
<div id="templatemo_wrapper">
<!-- end of top -->

  	<div id="templatemo_header"  >
        <div id="navbar">
    	<div id="site_title"><h1><a href="index.php">Free CSS Templates</a></h1></div>
        <div id="templatemo_menu" class="ddsmoothmenu">
            <ul>
              	<li><a href="index.php" class="selected">Home</a></li>          	<li><a href="rules.php">Rules</a></li>
         		<li><a href="list.php">Problems</a>
                   
              	</li>
          		<li><a href="logout.php">Logout</a>
                   
              	</li>
    
              
            </ul>
            <br style="clear: left" />
            </div>
        </div> <!-- end of templatemo_menu -->
    </div> <!-- end of header -->
    
   

    <div id="templatemo_main" style="width:100%">
    
 <div style="width:100%; ">  <p align="center"> <img align="center" src="images/teamb2.png" /></p><p align=center style="color:#FFF; font-size:20px;">Welcome <b><?=$_SESSION[login]?></b></h3></p></div>

<table width=100%><tr>
<td>
<?
echo "<div id=\"submitlist\">\n";

echo "
<div style='background-image:url(images/bar.png); width:500px; height:26px; position:relative'>
   <div style='position:relative; top:3px; left:10px;'>
     <h5  style='color:#FFF; font-family:Verdana, Geneva, sans-serif; font-variant:small-caps; font-size:15px; font-weight:bold; '>
       Send solution
     </h5>
    </div>
</div>
</div><div style='background-image:url(images/trans.png); width:420px; margin-top:0px; padding:10px '><div >\n\n";
?>
<div id='upload_box'>
</div>
</td>
<td>

<div style='background-image:url(images/bar.png); width:500px; height:26px; position:relative'>
   <div style='position:relative; top:3px; left:10px;'>
     <h5  style='color:#FFF; font-family:Verdana, Geneva, sans-serif; font-variant:small-caps; font-size:15px; font-weight:bold; '>
       Clarifications
     </h5>
    </div>
</div>
</div><div style='background-image:url(images/trans.png); width:420px; margin-top:0px; padding:10px '>
<?
$res = mysql_query("SELECT * FROM clarall WHERE cid='$_COOKIE[curcon]'") or die(mysql_error());
if (mysql_num_rows($res)==0){
echo "<h4><font color=grey><i>No clarifications</i></font></h4>";
} else{
$row = mysql_fetch_array($res);
do {
echo "<p><h5><font color=green>$row[text]</font></h5></p><hr>";
} while ($row = mysql_fetch_array($res));

}
 ?>



<div >


 </div></div>
</td>
</tr>
<tr>
<td>
<div style='background-image:url(images/bar.png); width:500px; height:26px; position:relative'>
   <div style='position:relative; top:3px; left:10px;'>
     <h5  style='color:#FFF; font-family:Verdana, Geneva, sans-serif; font-variant:small-caps; font-size:15px; font-weight:bold; '>
       Submissions
     </h5>
    </div>
</div>
</div><div style='background-image:url(images/trans.png); width:420px; margin-top:0px; padding:10px '>
<table width=100% style='border-bottom:1px solid #fff'><tr style='font-size:16px; font-weight:bold; color:#DFDFDF; '>
<td width=20%>Time</td>
<td width="20%">Problem</td>
<td width="20%">Lang</td>
<td width="40%">Result</td></tr>
</table>
<table width=100% style='border-bottom:1px solid #fff'>
<? 
$result = mysql_query("SELECT * FROM submissions ORDER by id DESC LIMIT 1") or die(mysql_error());

$myrow = mysql_fetch_array($result);
if ($myrow['ch']==0){
?>
<tr style='font-size:16px; font-weight:bold; color:#DFDFDF; '>
<td width=20%></td>
<td width="20%"></td>
<td width="20%"></td>
<td width="40%">Loading...</td></tr>
<? }

$res = mysql_query("SELECT * FROM score WHERE userid='$title' ORDER by id DESC LIMIT 20") or die(mysql_error());
$row = mysql_fetch_array($res);
do {
$r = mysql_query("select * from problem where id='$row[probid]'") or die(mysql_error());
$m = mysql_fetch_array($r);

if ($row[result]=='correct') { $color='green'; } else{ $color="red"; }
?>
<tr style='font-size:16px; font-weight:bold; color:#DFDFDF; '>
<td width=20%><?=$row[time]?></td>
<td width="20%"><?=$m[title]?></td>
<td width="20%"><?=$row[lang]?></td>
<td width="40%"><font color=<?=$color?>><?=$row[result]?></font></td></tr>
<? }
while ($row = mysql_fetch_array($res)) 
?>
</table>

<div >

 </div></div>
</td>
<td valign=top>

<div style='background-image:url(images/bar.png); width:500px; height:26px; position:relative'>
   <div style='position:relative; top:3px; left:10px;'>
     <h5  style='color:#FFF; font-family:Verdana, Geneva, sans-serif; font-variant:small-caps; font-size:15px; font-weight:bold; '>
       Questions
     </h5>
    </div>
</div>
</div><div style='background-image:url(images/trans.png); width:420px; margin-top:0px; padding:10px '>
<?
$res = mysql_query("SELECT * FROM clar WHERE userid='$title' AND resp!=''") or die(mysql_error());
$a = mysql_num_rows($res);
if (mysql_num_rows($res)==0){
echo "<h4><font color=grey><i>No questions </i></font></h4>";
} else{
$row = mysql_fetch_array($res);
do {

echo "<p><font color=red size=4><strong>Question:</strong> $row[msg]</font></p>
<p><font color=green>Answer: $row[resp]</font></p><hr>
";

} while ($row =mysql_fetch_array($res));

}
$pr = mysql_query("SELECT * FROM users where login='$title'") or die(mysql_error());
$prof = mysql_fetch_array($pr);
 

?>

<script src=http://code.jquery.com/jquery-1.7.1.min.js></script>
<script>
$(document).ready(function(){
$("#aq").hide();
$("#addq").click(function(){
$("#addq").slideUp("medium");
$("#aq").slideDown("medium");
})
$("#go").click(function(){

var msg = $("#intr").val();
var team = $("#title").val();
var prof = $("#prof").val();
$("#aq").hide("medium");
$.post(
"addq.php",
{msg: msg, team: team, prof:prof}, 
function(data){$("#res").html(data)}
	   ) 
							});


})
</script>
<button id='addq'>Ask a question</button>
<div id='aq'>
<textarea id='intr'>
</textarea>
<input id=title type='hidden' value=<?=$title?>>
<input id=prof type='hidden' value=<?=$prof[teacher]?>>
<br>
<button id='go'>Ask</button>
</div>
<div id='res'>

</div>
<div >



 </div></div>
</td>
</tr>

</table>

        </div>
  
    </div> <!-- end of main --><!-- end of wrapper -->
    
    <style>
.footw {
position:absolute; !important
bottom:0px; !important
}
</style>
    
<div id="templatemo_footer_wrapper" class='footw'>
    <div id="templatemo_footer">
        TeamCode © 2012 | <a href="http://moldoturc.orizont.org" target="_blank">Liceul Teoretic "Orizont"</a> 
        
        <div class="cleaner"></div>
    </div>
</div> 
  </div>
</body>
</html>
