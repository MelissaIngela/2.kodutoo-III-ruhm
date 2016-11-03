<?php 
	// functions.php
	require("../../config.php");
	session_start();
	
	$database = "if16_melissabramanis";
	
	//var_dump($GLOBALS);
	
	function signup($email, $password, $name) {
		
		$mysqli = new mysqli(
		
		$GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"],  
		$GLOBALS["serverPassword"],  
		$GLOBALS["database"]
		
		);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, name) VALUES (?, ?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("sss", $email, $password, $name );
		if ( $stmt->execute() ) {
			echo "salvestamine õnnestus";	
		} else {	
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	
	function login($email, $password) {
		
		$notice = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],  $GLOBALS["serverPassword"],  $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		
			SELECT id, email, password, created
			FROM user_sample
			WHERE email = ?
		
		");
		// asendan ?
		$stmt->bind_param("s", $email);
		
		// määran muutujad reale mis kätte saan
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		
		// ainult SLECTI'i puhul
		if ($stmt->fetch()) {
			
			// vähemalt üks rida tuli
			// kasutaja sisselogimise parool räsiks
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				// õnnestus 
				echo "Kasutaja ".$id." logis sisse";
				
			$_SESSION["userId"] = $id ;
			$_SESSION["userEmail"] = $emailFromDb;
			
			header("Location: data.php");
			exit();
				
			} else {
				$notice = "Vale parool!";
			}
			
		} else {
			// ei leitud ühtegi rida
			$notice  =  "Sellist emaili ei ole!";
		}
		return $notice;
	}
	
	
	function note($note, $main, $content) {
		
		$mysqli = new mysqli(
		
		$GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"],  
		$GLOBALS["serverPassword"],  
		$GLOBALS["database"]
		
		);
		$stmt = $mysqli->prepare("INSERT INTO colorNotes (note, main, content) VALUES (?, ?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("sss", $note, $main, $content );
		if ( $stmt->execute() ) {
			echo "salvestamine õnnestus  " ;	
		} else {	
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	function getAllNotes (){
		
		$mysqli = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"],  $GLOBALS["serverPassword"],  $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare(" SELECT id, note, main, content FROM colorNotes");
		
		$stmt->bind_result($id, $note, $main, $content);
		
		$stmt->execute();
		
		$result = array();
		
		while($stmt->fetch()){
			//echo $note."<br>";
			
			$object = new StdClass();
			$object->id = $id;
			$object->note = $note;
			$object->maain = $main;
			$object->content = $main;
			
			
			
			array_push($result, $object);
		}
		return $result;
	}
	
	function cleanInput ($input) {
		// eemaldab tühikud
		$input = trim($input);
		
		
		$input = stripslashes($input);
		
		$input = htmlspecialchars($input);
		
		return $input;
	}
	
	
	
	/*function sum($x, $y) {
		
		$answer = $x+$y;
		
		return $answer;
	}
	
	function hello($firstname, $lastname) {
		
		return 
		"Tere tulemast "
		.$firstname
		." "
		.$lastname
		."!";
		
	}
	
	echo sum(123123789523,1239862345);
	echo "<br>";
	echo sum(1,2);
	echo "<br>";
	
	$firstname = "Romil";
	
	echo hello($firstname, "R.");
	*/
?>