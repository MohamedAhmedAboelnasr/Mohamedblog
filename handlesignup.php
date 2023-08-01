<?php 
if(!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["password"])){
    $name=$_POST["name"];
    $email=$_POST["email"];
    $password=$_POST["password"];
require_once("Classes.php");

    users::signup($name,$email,$password);
    header("location:signup.php?msg=done");

}
   


else{ 
    echo"you ";
}