<?php 

	include 'SQLiteConnection.php';
 
	$pdo = (new SQLiteConnection())->connect();

	$id = $_GET['hidden_id'];

	$query_phone_number = $pdo->prepare("SELECT * From phones WHERE person_id = :id");

	$query_phone_number->bindValue(':id', $id);
	
	$query_phone_number->execute();

	$rowq = $query_phone_number->fetch(\PDO::FETCH_ASSOC);

	if($rowq == false){
		
		if(isset($_GET['phone_number'])){

			$phone_num = $_GET['phone_number'];

			$query_phone_number1 = $pdo->prepare("INSERT INTO phones(id,phone_number,person_id) VALUES (null,:phone_num,:person_id)");

			$query_phone_number1->bindValue(':phone_num', $phone_num);

			$query_phone_number1->bindValue(':person_id', $id);
			
			$query_phone_number1->execute();
		}

	}else{

		$phone_num2 = $_GET['phone_number'];

		$query_phone_number2 = $pdo->prepare("UPDATE phones SET phone_number = :phone_num WHERE person_id = :person_id");

		$query_phone_number2->bindValue(':phone_num', $phone_num2);

		$query_phone_number2->bindValue(':person_id', $id);
			
		$query_phone_number2->execute();

	}		

	header("Location: index.php");

 ?>