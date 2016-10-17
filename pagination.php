<?php    

include 'SQLiteConnection.php';

$pdo = (new SQLiteConnection())->connect();

/*******************************************************************************/
  
$record_per_page = 40;
  
$page = '';  
$output = '';
 
if(isset($_POST["page"])){  

  $page = $_POST["page"];  

}
else{  

  $page = 1;  

}  

$start_from = ($page - 1)*$record_per_page;  

if (isset($_POST["search"])){ 

  $user_search = $_POST["search"]; 

}
else{

  $user_search = "";

}

$result = $pdo->prepare("SELECT persons.id,persons.first_name, persons.last_name,persons.job_title,persons.gender,persons.email,phones.phone_number 
						FROM persons 
						LEFT JOIN phones 
						ON phones.person_id =persons.id 
						WHERE persons.last_name 
						LIKE '%$user_search%' 
						LIMIT :offset, :rowsperpage;"); 

$result->bindValue(':offset', $start_from);
$result->bindValue(':rowsperpage', $record_per_page); 
$result->execute();
 
$output .= "  
      <table class='table table-bordered'>  
           <tr>  
                <th style='text-align: center;'>id</th>
                <th style='text-align: center;'>first_name</th>
                <th style='text-align: center;'>last_name</th>
                <th style='text-align: center;'>job_title</th>
                <th style='text-align: center;'>gender</th>
                <th style='text-align: center;'>email</th>
                <th style='text-align: center;'>phone_number</th>
                <th style='text-align: center;'></th> 
           </tr>  
		";
		
while($row = $result->fetch(\PDO::FETCH_ASSOC)){

      $output .= "  
           <tr>  
              <td style='text-align: center;'>".$row['id']."</td>
              <td style='text-align: center;'>".$row['first_name']."</td>
              <td style='text-align: center;'>".$row['last_name']."</td>
              <td style='text-align: center;'>".$row['job_title']."</td>
              <td style='text-align: center;'>".$row['gender']."</td>
              <td style='text-align: center;'>".$row['email']."</td>
              <td style='text-align: center;'>
              <form action='action.php' method='get'>
                <input type='text'  name='phone_number' value=".$row['phone_number'].">
                <input type='hidden' name='hidden_id' value=".$row['id'].">
                <input type='submit' value='Submit'>
              </form>
              </td>
              <td style='text-align: center;'><a href='delete.php?row=".$row['id']."' onclick=\"return confirm('Are you sure?')\">Delete Row</a></td>
           </tr>  
      ";  
}  

$output .= '</table>
             <br />
             <div align="center">';  

$sql = "SELECT COUNT(*) FROM persons WHERE last_name LIKE '%$user_search%'";

$total_records = 0;

if ($res = $pdo->query($sql)) {
    
  if ($res->fetchColumn() > 0) {

    $sql = "SELECT * FROM persons WHERE last_name LIKE '%$user_search%' ORDER BY id DESC";

    foreach ($pdo->query($sql) as $row) {

      $total_records++;

    }

  }else {
	  
      $output .= "No rows matched the query.";
	  
  }
} 
  
$total_pages = ceil($total_records/$record_per_page); 
 
for($i=1; $i<=$total_pages; $i++){

     $output .= "<span class='pagination_link' style='cursor:pointer; padding:6px; border:1px solid #ccc;' id='".$i."'>".$i."</span>";  

}

$output .= '</div><br /><br />'; 

echo $output;  
?> 