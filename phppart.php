<?php
/*
$_POST['input_str'] != null === input_str is not empty string and not null 
chop()	Removes whitespace or other characters from the right end of a string
3 parameter is exploded by : and after by , . Others by :
*/
$final_string = "";
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
  echo $type . "<br>" ;
  echo $name . "<br>" ;
  echo $parameters . "<br>" ;
  echo  $return_value . "<br>";
  /* at this point any string is parsed accordingly
   now the checking part begins 
  */
  //checking Type
   /* this is suppose to define what code to return */
  switch($type){
  	case "CreateDB" : echo "The case is ". $type ; break;
	case "CreateTB" : echo "The case is ". $type ; break;
	case "Write" : echo "The case is ". $type ;  break;
	case "Read" :  echo "The case is ". $type ; break;
	case "Update" :  echo "The case is ". $type ; break;
	case "Delete" : echo "The case is ". $type ;  break;
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