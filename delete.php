<?php 

	include 'SQLiteConnection.php';
 
	$pdo = (new SQLiteConnection())->connect();

	$row = $_GET['row'];

	$delete_phones_row = $pdo->prepare("DELETE FROM phones WHERE person_id = :id");

	$delete_phones_row->bindValue(':id', $row);
	
	$delete_phones_row->execute();


	$delete_persons_row = $pdo->prepare("DELETE FROM persons WHERE id = :id");

	$delete_persons_row->bindValue(':id', $row);
	
	$delete_persons_row->execute();

	header("Location: index.php");
	
 ?>