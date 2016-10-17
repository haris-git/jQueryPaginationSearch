<!DOCTYPE html>  
 <html>  
      <head>  
           <title>Protocol</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
      </head>  
      <body>  
           <br />
		   <br />  
           <div class="container">  
                <h3 align="center">Protocol</h3>
				<br />
                  <p>Search by Last Name:</p>
                  <div class="form-group">  
                     <div class="input-group">
						<form method="post">
                          <input type="text" name="search" id="search" placeholder="Search by Last Name" class="form-control" />
						  <input type="submit" id="submitbtn"/>
						</form>
						
                     </div>  
                  </div>  
                  <br />  
                <div class="table-responsive" id="pagination_data">
                </div>  
           </div>  
      </body>  
 </html>  
 <script>  
 $(document).ready(function(){
      
      load_data();
      
      function load_data(page,search)  
      {  
           $.ajax({  
                url:"pagination.php",  
                method:"POST",  
                data:{page:page, search:search},
                success:function(data){  
                     $('#pagination_data').html(data);  
                }  
           });  
      }  
      $(document).on('click', '.pagination_link', function(){  
           var page = $(this).attr("id");
		   
           load_data(page);
		   		   
      });
	  $("form").submit(function(event){  
		   event.preventDefault();
           var page = $(document).attr("id");
		   var search = $('#search').val();
		   
           load_data(page,search);  
      });
        
 });
 </script>  