<h2>Player 1: <span style="color:red"><?=$_COOKIE["p1"]?></span></h2>
<h2>Player 2: <span style="color:red"><?=$_COOKIE["p2"]?></span></h2>


<form action="game.php" method="post">
Player 1: <input type="text" name="p1"><br>
Player 2: <input type="text" name="p2"><br>
Bet:<input type="text" name="bet"><br>
<input type="submit" value="Go">
</form>
<?
if(!isset($_COOKIE["p1"])){
	setcookie("p1","100",time()+10000);
	setcookie("p2","100",time()+10000);
	header("Location:game.php");
	
}
if(isset($_POST["p1"])){
	$n = rand(1,100);
	$bet = $_POST["bet"];
	$p1 = abs($_POST["p1"]-$n);
	$p2 = abs($_POST["p2"]-$n);
	echo "<h3>The number was: $n</h3>";
	if($p1<$p2){
		echo "Player 1 wins";
		$_COOKIE["p1"] +=$bet;
		$_COOKIE["p2"] -=$bet;
		setcookie("p1",$_COOKIE["p1"],time()+99999);
		setcookie("p2",$_COOKIE["p2"],time()+99999);
		
	} 
	if($p1>$p2){
		echo "Player 2 wins";
		$_COOKIE["p2"] +=$bet;
		$_COOKIE["p1"] -=$bet;
		setcookie("p1",$_COOKIE["p1"],time()+99999);
		setcookie("p2",$_COOKIE["p2"],time()+99999);
		
	} if($p1 == $p2) echo "Friendship wins";

}


?>