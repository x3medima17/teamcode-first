<?
function show_intro(){
?>
<div id="intro_login" class="hid">
<table border=0>
	<tr><td id="left_intro" >
   <p align='center'><img src='images/signup.png' ></p>
	</td>
	<td id="right_intro">
<p align='center'><img src='images/login.png'></p>
	</td>
</tr>
<tr><td>
   Signup
	</td>
	<td>
Login
	</td>
</tr>
</table>
</div>

<?
}
function show_login(){
?>
<div id="show_login" class="hid">
<table border=0>
	<tr>
<td><p>Login:</p></td>
<td><input type="text" id="login"></td>
</tr>
    <tr>
<td><p>Password:</p></td> 
<td><input type="password" id="pass"></td>
</tr>
<tr>
<td><p>Login as:</p></td>
<td><select id="type"><option value="student">Student</option><option value="teacher">Teacher</option></td>
</tr>
<tr><td><p><button id="go_login" >Login</button></td><td><div id='result'></div></td></tr>
</table>
</div>
<?
}

function choose_intro(){
?>
<div id="choose_intro" class="hid">
<table border=0>
	<tr><td id="left_choose" >
   <p align='center'><img src='images/teacher.png' ></p>
	</td>
	<td id="right_choose">
<p align='center'><img src='images/student.png'></p>
	</td>
</tr>
<tr><td>
   Teacher
	</td>
	<td>
Student
	</td>
</tr>
</table>
</div>

<?
}
function show_signup_teacher(){
?>
<div id="signup_teacher" class="hid">
<table border=0>
<tr>
<td>Login:</td><td><input type="text" id="teacher_login" class="signup_input_teacher"></td><td id='signup_teacher_login_check' v='0' class='ch_teacher'></td>
</tr>
<tr>
<td>Name:</td><td><input type="text" id="teacher_name" class="signup_input_teacher"></td><td id='signup_teacher_name_check' v='0' class='ch_teacher'></td>
</tr>
<tr>
<td>Surname:</td><td><input type="text" id="teacher_surname" class="signup_input_teacher"></td><td id='signup_teacher_surname_check' v='0' class='ch_teacher'></td>
</tr>
<tr>
<td>Password:</td><td><input type="password" id="teacher_pass" class="signup_input_teacher"></td><td id='signup_teacher_pass_check' v='0' class='ch_teacher'></td>
</tr>
<tr>
<td>Repeat password:</td><td><input type="password" id="teacher_pass_ch" class="signup_input_teacher"></td><td id='signup_teacher_pass_ch_check' v='0' class='ch_teacher'></td>
</tr>
<tr>
<td>E-mail:</td><td><input type="text" id="teacher_email" class="signup_input_teacher"></td><td id='signup_teacher_email_check' v='0' class='ch_teacher'></td>
</tr>
<tr>
<td>Telephone:</td><td><input type="text" id="teacher_tel" class="signup_input_teacher"></td><td id='signup_teacher_tel_check' v='0' class='ch_teacher'></td>
</tr>
<tr>	
<td><input type="button" id="singup_teacher_go" value="Signup"></td>
<td><div id="signup_res" style="color:red"></div></td>
</tr>
</table>
</div>
<?
}
/////////////////

function show_signup_student(){
?>
<div id="signup_student" class="hid">
<table border=0>
<tr>
<td>Login:</td><td><input type="text" id="student_login" class="signup_input_student"></td><td id='signup_student_login_check' v='0' class='ch_student'></td>
</tr>
<tr>
<td>Name:</td><td><input type="text" id="student_name" class="signup_input_student"></td><td id='signup_student_name_check' v='0' class='ch_student'></td>
</tr>
<tr>
<td>Surname:</td><td><input type="text" id="student_surname" class="signup_input_student"></td><td id='signup_student_surname_check' v='0' class='ch_student'></td>
</tr>
<tr>
<td>Password:</td><td><input type="password" id="student_pass" class="signup_input_student"></td><td id='signup_student_pass_check' v='0' class='ch_student'></td>
</tr>
<tr>
<td>Repeat password:</td><td><input type="password" id="student_pass_ch" class="signup_input_student"></td><td id='signup_student_pass_ch_check' v='0' class='ch_student'></td>
</tr>
<tr>
<td>E-mail:</td><td><input type="text" id="student_email" class="signup_input_student"></td><td id='signup_student_email_check' v='0' class='ch_student'></td>
</tr>
<tr>
<td>School:</td><td><input type="text" id="student_school" class="signup_input_student"></td><td id='signup_student_school_check' v='0' class='ch_student'></td>
</tr>
<tr>
<td>Teacher:</td><td><input type="text" id="student_teacher" class="signup_input_student"></td><td id='signup_student_teacher_check' v='0' class='ch_student'></td>
</tr>
<tr>	
<td><input type="button" id="singup_student_go" value="Signup"></td>
<td><div id="signup_res_student" style="color:red"></div></td>
</tr>
</table>
</div>
<?
}
?>