<?php

require '../database/Database.php';

if (isset($_GET['q'])) {
	$q = htmlentities($_GET['q']);
	
	$bdd = new Database();
	
	$query = "SELECT title FROM brands
			  WHERE title LIKE '". $q ."%'
			  LIMIT 0, 20";
	
	$result = $bdd->query($query) or die(print_r($bdd->errorInfo()));
	
	while ($r = $result->fetch(PDO::FETCH_ASSOC)) {
		echo $r['title'] . "\n";
	}
}