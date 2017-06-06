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
	$intermidiate_var = $intermidiate_var . ''. $parameters[$x].  ' VARCHAR(30) NOT NULL' . ',
	';
	}else{
    $intermidiate_var = $intermidiate_var .''.  $parameters[$x] .  ' VARCHAR(30) NOT NULL )";
    '  ;
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
	case "Write" :   break;
	case "Read" :   break;
	case "Update" :  break;
	case "Delete" :   break;
  }
  echo " <a id='link_to_prev'  href=\"javascript:history.go(-1)\" style ='visibility : hidden;'>GO BACK</a>";
  echo "<script>
    document.getElementById('link_to_prev').click();
</script>";



}
?>