<?php
/*
$_POST['input_str'] != null === input_str is not empty string and not null 
chop()	Removes whitespace or other characters from the right end of a string
3 parameter is exploded by : and after by , . Others by :
*/
$final_string = "";
$body_of_method = "";
$name_of_function = "";
$parameter_of_function = "";

$error_message = "";

if( $_POST['input_str'] != null ){ 
 echo $_POST['input_str'] . "<br>";
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
</br>$servername =$'. $parameters[0]. ';'. '
</br>$username =$'. $parameters[1]. ';'. '
</br>$password =$'. $parameters[2]. ';'. '

</br>// Create connection
</br>$conn = new mysqli($servername, $username, $password);

</br>// Check connection
</br>if ($conn->connect_error) {
</br>    die("Connection failed: " . $conn->connect_error);
</br>} ';
//echo $body_of_method . '<br>';
//something about return value
$final_string = $name_of_function . $body_of_method . ' <br>}';
echo $final_string;  // <-- this is 'method'(final string) that we are getting from out code and printing to user
  	break;
  	case "CreateDB" :  

  	break;
	case "CreateTB" :  break;
	case "Write" :   break;
	case "Read" :   break;
	case "Update" :  break;
	case "Delete" :   break;
  }
  //checking return value
  /* this is suppose to concatenate to the end of returned code*/
  switch($return_value) 
  {
    case "String" : $return ; break;
    case "Int" :   break;
    case "Bool" :  break;
  }

}
?>