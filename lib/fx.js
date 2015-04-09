$(document).ready(function(){
function login_check(login,pass){
$.post("login_check.php",{login:login,pass:pass},function(data){
$("#result").html(data);

})

}

})