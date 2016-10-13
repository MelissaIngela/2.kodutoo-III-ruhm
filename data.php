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
			isset($_POST["color"]) && 
			!empty($_POST["note"]) && 
			!empty($_POST["color"]) 
	) {
		$notice = note($_POST["note"], $_POST["color"]);
		
		
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



		<h2>Märkmed<h2>
		<form method="POST">
			
			<label>Tekst</label><br>
			
			<input name="note" type="text" <textarea rows="4" cols="50">
						
			<br><br>
			
			<label>Värv</label><br>
			
			<input name="color" type="color">
			
			<br><br>			
						
			<input type="submit">
		
		</form>
		
<h2> arhiiv </h2>
		
<?php

	foreach ($notes as $n) {
		
		$style = "width:200px; float:left; min-height:200px; border: 1px solid gray; background-color: " .$n->noteColor.";";
		
		echo "<p style= ' ".$style." '>".$n->note."</p>";
		
	}		
		
?>		

<h2 style="clear:both;"> Tabel </h2>
<?php

    $html = "<table>";
	
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>Märkus</th>";
			$html .= "<th>Värv</th>";
		$html .= "</tr>";
	
    foreach ($notes as $note){
		$html .= "<tr>";
			$html .= "<td>".$note->id."</td>";
			$html .= "<td>".$note->note."</td>";
			$html .= "<td>".$note->noteColor."</td>";
		$html .= "</tr>";
		
	}

	$html .="</table>";
	echo $html;

?>






























