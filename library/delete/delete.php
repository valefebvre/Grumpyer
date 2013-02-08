<?php

require '../database/Database.php';

if ($_POST['id']) {
	
	$id = $_POST['id'];
	
	$query = "DELETE FROM grumps
			  WHERE id = '$id'";
	$bdd = new Database();
	$delete = $bdd->alterationAction($query);	
}

