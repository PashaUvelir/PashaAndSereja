<?php
session_start();
$final_string = "";
if($_SESSION['str_output'] != NULL){
 $final_string = $_SESSION['str_output'];

}
?>
<!DOCTYPE html>
<html>
	<html lang="en">
	<head>
 	 	<title>Bootstrap Example</title>
  		<meta charset="utf-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1">
  		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  		<link rel="stylesheet" href="styles.css">
	</head>
<body>
	<div class="container">
		<h1 >Welcome</h1>
		<div id="div_description_of_site">
		This site is created for students. The main purpose behind it is
		a easy way to get different names for the same methods. So stop do copy-paste over and over.
		</div>
		<form action="phppart.php" method="post" id='form_inputform'>
    		<div class="form-group">
      		<label for="form_inputstr">Write your command here:
      		</label>
      		<textarea class="form-control" id="textarea_inputtext" rows="4" cols="50"  placeholder="Enter legit command(look at description below). 
For example: Type:Write;Name:writeToDB;Parameters:name,age,school,country;Return value:Bool" name="input_str">Type: Delete;Name: writeToDB;Parameters: Connectishe,myTable,id,age,familyname,country;Return value:Bool</textarea>
      		<input type="submit">
    		</div>
		</form>    
		<div>Copy and paste this code into your HTML file. It`s that easy!</div>
		<form action="phppart.php" method="post" id='form_inputform'>
    		<div class="form-group">
      		<label for="output_inputstr">Your code is:
      		</label>
      		<textarea class="form-control" id="textarea_outputtext" rows="12" cols="50"  name="output_str"><?php echo $final_string;?></textarea>
      		
    		</div>
		</form>   
		<div id="div_instruction">Instruction:<br></div>
		<div> 
			<strong>All identifiers should be divide by ; symbol </strong><br>
			The <strong>Type</strong> is type of operation you plan to do: <br>
			1) CreateConnection - if you want to create connection(<strong>needed to all others methods</strong>) <br>
			2) CreateDB -if you want to create database<br>
			3) CreateTB - if you want to create table <br>
			4) Write - if you want to write to database<br>
			5) Read - if you want to read from database<br>
			6) Update - if you want to update records in database<br>
			7) Delete - if you want to delete records in database<br><br>
			The <strong>Name</strong> is the name of the function you will get <br><br>
			The <strong>Parameters</strong> is the parameters that method will have. First
			paramater must be <i>connection</i> for all(excluding CreateConnection) <strong>Types</strong> <br>
			Others parameters are: <br>
			1) CreateConnection : 1 - name of server, 2 - user name for connection, 3 - password for connecting . Maximum number of parameters : 3 <br>
			2) CreateDB : 1- connection that you can get from 'CreateConnection' or your own connection, 2 - name of database to be created . Maximum number of parameters : 2<br>
			3) CreateTB : 1 - connection that you can get from 'CreateConnection' or your own connection, 2 - name of existing database, 3 - name of table to be created , 4 - name of column id(you can call it whatever you want but it will behave like id anyway),
			 5-and-further - names of other columns in table . Maximum number of parameters : N <br>
			4) Write : 1 - connection that you can get from 'CreateConnection' or your own connection, 2 - name of table, 3-and-further - values to insert . Maximum number of parameters : N <br>
			5) Read : 1 - connection that you can get from 'CreateConnection' or your own connection, 2 - name of table. Maximum number of parameters : 2 <br>
			6) Update : 1 - connection that you can get from 'CreateConnection' or your own connection, 2 - name of table, 3 - id of upgrading record, 
			4-and-further - values that will be inserted. Maximum number of parameters : N <br>
			7) Delete : 1 - connection that you can get from 'CreateConnection' or your own connection, 2 - any parameter that will be clause to identify which row is being updated. Maximum number of parameters : 2<br><br>
			The <strong>Return Value</strong> is value that will be returned if operation is successful. For successful operation it will be 1,true
			"true", for unsuccessful it will be 0,false,"false". This parameter can have values:<br>
			1) String - for "true"/"false"<br>
			2) Int - for 1/0;<br>
			3) Bool - for true/false;<br>
			<br><br><br>

		</div> 

	</div>
</body>
</html>