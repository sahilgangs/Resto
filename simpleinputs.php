<?php
session_start();


  
 
   if($_SERVER['REQUEST_METHOD']=='POST'){
  // echo $_SERVER["DOCUMENT_ROOT"];  // /home1/demonuts/public_html
//including the database connection 
   	
       require('config.php');
       
    $userid = $_POST['userid'];

 	$cuisine = $_POST['cuisine'];
 	$restaurant = $_POST['restaurant'];
 	$ocassion = $_POST['ocassion'];
 	$latitude=$_POST['latitude'];
 	$longitude=$_POST['longitude'];
 
 
  
	 if( $cuisine == '' || $restaurant == ''|| $ocassion == ''||$latitude==''||$longitude==''){
	        echo json_encode(array( "status" => "false","message" => "Parameter missing!") );
	 }
	        else{ 

	       
	        	 $query = "INSERT INTO inputs (userid,cuisine,restaurant,ocassion,latitude,longitude) VALUES ('$userid','$cuisine','$restaurant','$ocassion','$latitude','$longitude')";

			 if(mysqli_query($con,$query)){
			    
			     $query= "SELECT * FROM inputs WHERE cuisine='$cuisine'";
	                     $result= mysqli_query($con, $query);
		             $emparray = array();
	                     if(mysqli_num_rows($result) > 0){  
	                     while ($row = mysqli_fetch_assoc($result)) {
                                     $emparray[] = $row;
                                   }
	                     }
			    echo json_encode(array( "status" => "true","message" => "Successfully inputted!" , "data" => $emparray) );
		 	 }else{
		 	 			$query = "SELECT * FROM inputs  WHERE userid ='$userid'";
        				$result = mysqli_query($con, $query);
        				if (mysqli_num_rows($result) > 0)
        				{
        					$query="UPDATE inputs SET userid=$userid,cuisine='$cuisine',restaurant='$restaurant',ocassion='$ocassion',latitude='$latitude',longitude='$longitude' WHERE userid=$userid";
        					if(mysqli_query($con,$query)){
			    
			     $query= "SELECT * FROM inputs WHERE cuisine='$cuisine'";
	                     $result1= mysqli_query($con, $query);
		             $emparray = array();
	                     if(mysqli_num_rows($result1) > 0){  
	                     while ($row = mysqli_fetch_assoc($result1)) {
                                     $emparray[] = $row;
                                   }
	                     }
			    echo json_encode(array( "status" => "true","message" => "Successfully updated!" , "data" => $emparray) );
		 	 }
        				}
        				else{

		 		 echo json_encode(array( "status" => "false","message" => "Error occured, please try again!") );}
		 	}
	    }
	            mysqli_close($con);
	 }
      else{
			echo json_encode(array( "status" => "false","message" => "Error occured, please try again!") );
	}
 
 ?>