<?php
session_start();
/*
$_POST['input_str'] != null === input_str is not empty string and not null 
chop()	Removes whitespace or other characters from the right end of a string
3 parameter is exploded by : and after by , . Others by :
*/
$final_string = "";
$body_of_method = "";
$name_of_function = "";
$parameter_of_function = "";
$return_value_variable_true = "";
$return_value_variable_false = "";
$error_message = "";

if( $_POST['input_str'] != null )
{ 
// echo $_POST['input_str'] . "<br>";
 list($type, $name, $parameters, $return_value) = explode(";",$_POST['input_str']);
 
  $type = explode(":",$type);
  $type = $type[1] ;
  $name = explode(":",$name);
  $name = $name[1];
  //parameters
  $parameters =  explode(":",$parameters);
  $parameters = $parameters[1];
  $parameters = explode(",",$parameters); // <-- array now
  //return value
  $return_value =  explode(":",$return_value);
  $return_value = $return_value[1];
  $type = trim($type); 
  $name = trim($name);
  $return_value = trim($return_value); // parameters are not trimmed here, because they are still array
  /*echo $type . "<br>" ;
  echo $name . "<br>" ;
  echo $parameters . "<br>" ;
  echo  $return_value . "<br>"; */
   
  /* at this point any string is parsed accordingly
   now the checking part begins 
  */
  //checking Type
   /* this is suppose to define what code to return */
   //checking return value
  /* this is suppose to concatenate to the end of returned code*/
   switch($return_value) 
  {
    case "String" : 
    	$return_value_variable_true = "'true'";
    	$return_value_variable_false = "'false'";
      break;
    case "Int" :  
		$return_value_variable_true = 1;
    	$return_value_variable_false = 0;
     break;
    case "Bool" :  
		$return_value_variable_true = TRUE;
    	$return_value_variable_false = FALSE;
    break;
  }
  //loop through parameters so that they all trimmed(others are trimmed earlier);
   for($x =0;$x < count($parameters) ; $x++){
   	$parameters[$x] = trim($parameters[$x]);
   }
   //checking correctness of type
  switch($type){
  	case "CreateConnection": 
  	/*
  	here parameters are from params that user gives us. So there should be loop through them
  	in this case there only can be 3 parameters, so looping 3 times.
  	 */
  	$name_of_function = 'function ' . $name . '(';
    $intermidiate_var = "";
    $comma_detector = true;
    for($i =0;$i <3;$i++)
    {
    	if($i === 3-1 ) $comma_detector = false;
   		if($comma_detector === true){
  		$intermidiate_var = $intermidiate_var .  "$" . $parameters[$i] . ',' ;
    	}else{
    	$intermidiate_var = $intermidiate_var .  "$" . $parameters[$i] ;
    }
  	
    }
    $intermidiate_var = $intermidiate_var ."){ ";
    $name_of_function = $name_of_function . $intermidiate_var ;
   // echo $name_of_function . '<br>' ;

     $body_of_method = '
$err_message  = "";     
$servername =$'. $parameters[0]. ';'. '
$username =$'. $parameters[1]. ';'. '
$password =$'. $parameters[2]. ';'. '

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
 $err_message ="err";
 } 
';
//echo $body_of_method . '<br>';
//something about return value
$body_of_method = $body_of_method . 'if($err_message != NULL){
return '. $return_value_variable_false . ";}else{" . 
"return ".$return_value_variable_true .";} " ;
$final_string = $name_of_function . $body_of_method . ' }';
$_SESSION['str_output'] = $final_string;
//echo $final_string;  // <-- this is 'method'(final string) that we are getting from out code and printing to user
  	break;
  	case "CreateDB" :  
  	// Create database
    $name_of_function = 'function ' . $name . '(';
    $intermidiate_var = "";
    $comma_detector = true;
    for($i =0;$i < 2 ;$i++)
    {
    	if($i === 2-1 ) $comma_detector = false;
   		if($comma_detector === true){
  		$intermidiate_var = $intermidiate_var .  "$" . $parameters[$i] . ',' ;
    	}else{
    	$intermidiate_var = $intermidiate_var .  "$" . $parameters[$i] ;
    }
  	
    }
    $intermidiate_var = $intermidiate_var ."){ ";
    $name_of_function = $name_of_function . $intermidiate_var ;
   // echo '<br>' .$name_of_function;

    $body_of_method = '
	$err_message  = "";
    $sql = "CREATE DATABASE $' . $parameters[1] . '";
	if ($'.$parameters[0] . '->query($sql) === TRUE) {
   return ' . $return_value_variable_true . ';
	} else {
    return ' . $return_value_variable_false . ';
}

$' .$parameters[0] .'->close();';
$final_string = $name_of_function . $body_of_method . ' }';
$_SESSION['str_output'] = $final_string;
//echo $final_string; // <-- this is 'method'(final string) that we are getting from out code and printing to user
  	break;
	case "CreateTB" : 
    // Create table
    $name_of_function = 'function ' . $name . '(';
    $intermidiate_var = "";
    $comma_detector = true;
    for($i = 0 ;$i < count($parameters) ;$i++)
    {
    	if($i === count($parameters) - 1 ) $comma_detector = false;
   		if($comma_detector === true){
  		$intermidiate_var = $intermidiate_var .  "$" . $parameters[$i] . ',' ;
    	}else{
    	$intermidiate_var = $intermidiate_var .  "$" . $parameters[$i] ;
    }
  	
    }
    $intermidiate_var = $intermidiate_var ."){ ";
    $name_of_function = $name_of_function . $intermidiate_var ;
   // echo '<br>' .$name_of_function;
//third parameter always id
// second is always name of table to create
    $body_of_method = '
// sql to create table 
//!!!!!!!CHANGE VARCHAR ON WHATEVER YOU WANT IF NECESSARY
$sql = "CREATE TABLE '. $parameters[1]. ' (   
'. $parameters[2] . ' INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
';
//there he is started
$comma_detector = true;
$intermidiate_var = "";
for($x = 3; $x < count($parameters);$x++) {
	if($x === count($parameters) - 1  ) $comma_detector = false;
	if($comma_detector === true){
	$intermidiate_var = $intermidiate_var .  $parameters[$x].  ' VARCHAR(30) NOT NULL' . ',
';
    $intermidiate_var =  ltrim($intermidiate_var);
	}else{
    $intermidiate_var = $intermidiate_var .  $parameters[$x] .  ' VARCHAR(30) NOT NULL )";
'  ;
    $intermidiate_var =  ltrim($intermidiate_var);
}
}
$body_of_method = $body_of_method . $intermidiate_var  ;  
//theres loop ending
$body_of_method = $body_of_method . 'if ($'.$parameters[0] . '->query($sql) === TRUE) {
    return '. $return_value_variable_true . " ;". ' 
} else {
    return' . $return_value_variable_false . " ;" .'
}

$'.$parameters[0]. '->close();';
    $final_string = $name_of_function . $body_of_method . ' }';
    $_SESSION['str_output'] = $final_string;
	//echo $final_string; // <-- this is 'method'(final string) that we are getting from out code and printing to user
	 break;
	case "Write" :
	//writing to DB
	$name_of_function = 'function ' . $name . '(';
    $intermidiate_var = "";
    $comma_detector = true;
    //creating name of function with parameters
   for($x = 0; $x < count($parameters);$x++) 
    {
    	if($x === count($parameters)-1 ) $comma_detector = false;
   		if($comma_detector === true){
  		$intermidiate_var = $intermidiate_var .  "$" . $parameters[$x] . ',' ;
    	}else{
    	$intermidiate_var = $intermidiate_var .  "$" . $parameters[$x] ;
    }
  	
    }
    $intermidiate_var = $intermidiate_var ."){ ";
//declaration of function and variables in it created
    $name_of_function = $name_of_function . $intermidiate_var ;
   // echo '<br>' .$name_of_function;

    $body_of_method = '
$sql = "INSERT INTO  $' . $parameters[1] . " (";
  	$intermidiate_var = "";
	$comma_detector = true;
	for($x = 2; $x < count($parameters);$x++) {
	if($x === count($parameters) - 1  ) $comma_detector = false;
	if($comma_detector === true){
	$intermidiate_var =  $intermidiate_var .  "YOUR_COLUMN".   ",";
    
	}else{
    $intermidiate_var = $intermidiate_var .  "YOUR_COLUMN" . ")";
    $intermidiate_var = $intermidiate_var . '
';
	}

}
$body_of_method = $body_of_method . $intermidiate_var;
$body_of_method = $body_of_method . 'VALUES(';

	$intermidiate_var = "";
	$comma_detector = true;
	for($x = 2; $x < count($parameters);$x++) {
	if($x === count($parameters) - 1  ) $comma_detector = false;
	if($comma_detector === true){
	$intermidiate_var =  $intermidiate_var . "$" . $parameters[$x].   ",";
    
	}else{
    $intermidiate_var = $intermidiate_var . "$" . $parameters[$x] . ")";
    $intermidiate_var = $intermidiate_var . '";
';
	}
	}
$body_of_method = $body_of_method . $intermidiate_var  ;  
$body_of_method = $body_of_method. 
	'if ($'.$parameters[0] . '->query($sql) === TRUE) {
   return ' . $return_value_variable_true . ';
	} else {
    return ' . $return_value_variable_false . ';
}

$' .$parameters[0] .'->close();';
$final_string = $name_of_function . $body_of_method . ' }';
$_SESSION['str_output'] = $final_string;
//echo $final_string; // <-- this is 'method'(final string) that we are getting from out code and printing to user
	 break;
	case "Read" :  
	$name_of_function = 'function ' . $name . '(';
    $intermidiate_var = "";
    $comma_detector = true;
    //creating name of function with parameters
   for($x = 0; $x < 2;$x++) 
    {
    	if($x === 2-1 ) $comma_detector = false;
   		if($comma_detector === true){
  		$intermidiate_var = $intermidiate_var .  "$" . $parameters[$x] . ',' ;
    	}else{
    	$intermidiate_var = $intermidiate_var .  "$" . $parameters[$x] ;
    }
  	
    }
    $intermidiate_var = $intermidiate_var ."){ ";
//declaration of function and variables in it created
    $name_of_function = $name_of_function . $intermidiate_var ;	
    $body_of_method = '
    $sql = "SELECT * FROM $'. $parameters[1] . '";';
 $body_of_method = $body_of_method . '
 $result = mysqli_query($'.$parameters[0] . ', $sql);
 if(mysqli_num_rows($result) > 0){
 	return $result;
 }
 else{
 return '. $return_value_variable_false .';	
 }
 mysqli_close($'. $parameters[0] .  ');' ;
$final_string = $name_of_function . $body_of_method . '
 }';
$_SESSION['str_output'] = $final_string ;
	 break;
	case "Update" : 
	/*$sql = "UPDATE MyGuests SET lastname='Doe' WHERE id=2";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
	*/
$name_of_function = 'function ' . $name . '(';
    $intermidiate_var = "";
    $comma_detector = true;
    //creating name of function with parameters
   for($x = 0; $x < count($parameters);$x++) 
    {
    	if($x === count($parameters)-1 ) $comma_detector = false;
   		if($comma_detector === true){
  		$intermidiate_var = $intermidiate_var .  "$" . $parameters[$x] . ',' ;
    	}else{
    	$intermidiate_var = $intermidiate_var .  "$" . $parameters[$x] ;
    }
  	
    }
    $intermidiate_var = $intermidiate_var ."){ ";
//declaration of function and variables in it created
    $name_of_function = $name_of_function . $intermidiate_var ;
    $body_of_method = '
    $sql = "UPDATE $' . $parameters[1] . ' SET WHERE '; 
    //changed part for update
    $intermidiate_var = ">REPLACE_IT_WITH_NAME_OF_COLUMN< = ";
	$comma_detector = true;
	for($x = 3; $x < count($parameters);$x++) {
	if($x === count($parameters) - 1  ) $comma_detector = false;
	if($comma_detector === true){
	$intermidiate_var =  $intermidiate_var . "$" . $parameters[$x].   ", >REPLACE_IT_WITH_NAME_OF_COLUMN< = ";
    
	}else{
    $intermidiate_var = $intermidiate_var . "$" . $parameters[$x] ;
    $intermidiate_var = $intermidiate_var . '';
	}
	}
	$body_of_method  = $body_of_method . $intermidiate_var;
    $body_of_method = $body_of_method . ' WHERE id = $' .$parameters[2] . '";';

   $body_of_method = $body_of_method . '
   if ($'. $parameters[0] . '->query($sql) === TRUE) {
    return' . $return_value_variable_true .';
} else {
    return ' . $return_value_variable_false . ';
}
$' .$parameters[0]. '->close();';
   // echo '<br>' .$name_of_function;
   $final_string = $name_of_function . $body_of_method . '
 }';
$_SESSION['str_output'] = $final_string ;


	 break;
	case "Delete" : 
	/*
	$sql = "DELETE FROM MyGuests WHERE id=3";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
	*/
$name_of_function = 'function ' . $name . '(';
    $intermidiate_var = "";
    $comma_detector = true;
    //creating name of function with parameters
   for($x = 0; $x < count($parameters);$x++) 
    {
    	if($x === count($parameters)-1 ) $comma_detector = false;
   		if($comma_detector === true){
  		$intermidiate_var = $intermidiate_var .  "$" . $parameters[$x] . ',' ;
    	}else{
    	$intermidiate_var = $intermidiate_var .  "$" . $parameters[$x] ;
    }
  	
    }
    $intermidiate_var = $intermidiate_var ."){ ";
//declaration of function and variables in it created
    $name_of_function = $name_of_function . $intermidiate_var ;
    $body_of_method = '
    $sql = "DELETE FROM $' . $parameters[1] . ' WHERE   >REPLACE_IT_WITH_NAME_OF_COLUMN< =  $' . $parameters[2] . '";'; 
	
$body_of_method = $body_of_method . '
if ($' . $parameters[0] . '->query($sql) === TRUE) {
return ' . $return_value_variable_true .';
} else {
    return ' . $return_value_variable_false . ';
}
mysqli_close($'.$parameters[0] . ');';
  $final_string = $name_of_function . $body_of_method . '
 }';
$_SESSION['str_output'] = $final_string ;

	  break;
  }
  echo " <a id='link_to_prev'  href=\"javascript:history.go(-1)\" style ='visibility : hidden;'>GO BACK</a>";
  echo "<script>
    document.getElementById('link_to_prev').click();
</script>";
}
?>