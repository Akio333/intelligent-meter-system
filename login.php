<html>
   <head>
      <title>Logging In...................</title>
   </head>
   <body style="background-image: url('img/blyat.gif');
    background-size: cover;
    background-repeat: no-repeat;">
   </body>
</html>

<?php
session_start();
require "vendor/autoload.php";
if(isset($_POST['username']) && isset($_POST['password'])){
    $username = ($_POST['username']);
    $password = ($_POST['password']);
    $pass_hash = md5($password);
    
    if(empty($username)){
        die("Empty or invalid email address");
    }
    
    if(empty($password)){
        die("Enter your password");
    }
    
    $con = new MongoDB\Client("mongodb://localhost:27017");
    if($con){
        
        $db = $con -> IMS;
        $collection = $db -> consumer;
        $qry = ["Consumer_Id" => $username, "password" => $pass_hash];
        $result = $collection -> findOne($qry);
        if($result){
            $cid = $result['Consumer_Id'];
            $_SESSION["userid"] = $cid; 
            header('Refresh: 5.5; URL = dashboard.php');
        }else{
            echo "Wrong combination of username and password";
        }
    }else{
        die("Mongo DB not connected!");
    }
}
?>