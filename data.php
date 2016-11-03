<?php

	require("functions.php");

	if(!isset ($_SESSION["userId"])){
		header("Location: login.php");
		exit();
	}
	
	if (isset($_GET["logout"])){
		
		session_destroy();
		
		header("Location: login.php");
		exit();
	}
	
	
	$notice = "";
	// mõlemad login vormi väljad on täidetud
	if (	isset($_POST["note"]) && 
			isset($_POST["main"]) &&
			isset($_POST["content"]) &&
			!empty($_POST["note"]) &&
			!empty($_POST["main"]) &&
			!empty($_POST["content"]) 
	) {
		$notice = note($_POST["note"], $_POST["main"], $_POST["content"]);
		
		
		$note = cleanInput($_POST["note"]);
		
		
	}
	
	$notes = getAllNotes();
	
	//echo"<pre>";
	//var_dump($notes  );
	//echo"</pre>";
	
?>

<h1>Data</h1>
<p>	
	Tere tulemast <?=$_SESSION["userEmail"];?> !
	<a href="?logout=1"> Logi välja </a>


</p>

<!DOCTYPE html>



		<h2> Sisesta enda resept<h2>
		<form method="POST">
			
			<label>Toidu nimi</label><br>
			
			<input name="note" type="text" <textarea rows="4" cols="50">
						
			<br><br>
			
			<label>Retsept</label><br>
			
			<input name="main" type="text">
			
			<br><br>			
			
			<label>Vaja minevad asjad</label><br>
			
			<input name="content" type="text">
			
			<br><br>
						
			<input type="submit">
		
		</form>
		


<h2 style="clear:both;"> Retseptide tabel </h2>
<?php

    $html = "<table>";
	
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>Toidu nimi</th>";
			
			$html .= "<th>Retsept</th>";
			
			$html .= "<th>Vaja minevad asjad</th>";
		$html .= "</tr>";
	
    foreach ($notes as $note){
		$html .= "<tr>";
			$html .= "<td>".$note->id."</td>";
			$html .= "<td>".$note->note."</td>";
			$html .= "<td>".$note->maain."</td>";
			$html .= "<td>".$note->content."</td>";
		$html .= "</tr>";
		
	}

	$html .="</table>";
	echo $html;

?>






























