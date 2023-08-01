<?php 
session_start();
require_once("Classes.php");
if(!empty($_POST["email"]) && !empty($_POST["password"])){
    function login(){
    $email=$_POST["email"];
    $password=$_POST["password"];
   $user=users::login($email,$password);
}
if($user==null){
    header("location:login.php?msg=no_Email_or_Password");

}
else{$role=$user->$role;
    $_SESSION["user"]=serialize($user);
    if($role=='user'){
        header("location:user.php");
    }
        header("location:admin.php");
 }

}else
{ header("location:profile.php");}
