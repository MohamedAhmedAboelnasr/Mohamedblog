<?php

use PSpell\Config;

class users{
    public  $name;
    public  $id;
    public  $email;
    private $password;

    public function __construct($name=null,$id=null,$email=null,$password=null) {
        $this->name=$name;
        $this->id=$id;
        $this->email=$email;
        $this->password=$password;
    }
    static function signup($name,$email,$password){

        $qry="insert into users (name,password,email) values('$name','$password','$email')";
        require_once("config.php");
        $cn=mysqli_connect(DB_NAME,DB_User_NAME,DB_NAME_PW,DB_host);
        // var_dump($cn);
        try{
        $rsult=mysqli_query($cn,$qry);}
        catch(\Throwable $thn){
    header("location:signup.php?msg=e_a_t");
        }
        var_dump($rsult);
        mysqli_close($cn);
    }

    static function login($email,$password){
        $user=null;
        $email=htmlspecialchars(trim($email));
        $password=trim(md5($password));
        $qry="select * from uswes where email ='$email' AND password='$password'";
        require_once("config.php");
        $cn=mysqli_connect(DB_NAME,DB_User_NAME,DB_NAME_PW,DB_host);
        $rsult=mysqli_query($cn,$qry);
        if($rsult= mysqli_fetch_assoc($rsult)){
            switch($rsult['$role']){
                case 'user':
                $id=$rsult['id'];
                $name=$rsult['name'];
                $email=$rsult['email'];
                $password=$rsult['password'];
                $user=new user($id,$name,$email,$password);
                break;
                case 'admin':
                    $id=$rsult['id'];
                    $name=$rsult['name'];
                    $email=$rsult['email'];
                    $password=$rsult['password'];
                    $user=new admin($id,$name,$email,$password);
                    break;
            }
        }
        return $user;
        
    }
}
class user extends users{
    public $role ='user';
    function showallmyposts(){
    $qry="SELECT * FROM posts WHERE users_id='$this->id";
    $cn=mysqli_connect(DB_NAME,DB_User_NAME,DB_NAME_PW,DB_host);
    $rsult=mysqli_query($cn,$qry);
    $data= mysqli_fetch_assoc($rsult);
    mysqli_close($cn);
    return $data;
    } 
    function Addpost($content,$title,$image){
        $user_id=$this->id;
        $qry="INSERT INTO  posts (content,title,users_id,image)values($content,$title,$image,$user_id)";
        $cn=mysqli_connect(DB_NAME,DB_User_NAME,DB_NAME_PW,DB_host);
        $rsult=mysqli_query($cn,$qry);

        mysqli_close($cn);
        return $rsult;
    }
    function Showpost(){
        $qry="SELECT * FROM posts WHERE users_id='$this->id";
        $cn=mysqli_connect(DB_NAME,DB_User_NAME,DB_NAME_PW,DB_host);
        $rsult=mysqli_query($cn,$qry);
        $data= mysqli_fetch_assoc($rsult);

        mysqli_close($cn);
        return $data;

    }
    function Deletepost(){
        $qry="DELETE * FROM posts WHERE users_id='$this->id";
        $cn=mysqli_connect(DB_NAME,DB_User_NAME,DB_NAME_PW,DB_host);
        $rsult=mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rsult;
    }
    function Editpost($content,$id){
        $qry="UPDATE  posts SET content='$content' where id=$id";
        $cn=mysqli_connect(DB_NAME,DB_User_NAME,DB_NAME_PW,DB_host);
        $rsult=mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rsult;
    }
    function Addcomment(){
    $qry = "insert into comments(content,post_id,user_id) values('xxx',2,1)";
    $cn=mysqli_connect(DB_NAME,DB_User_NAME,DB_NAME_PW,DB_host);
    $rsult=mysqli_query($cn,$qry);
    mysqli_close($cn);
    return $rsult;
    }
}
class admin extends users{public $role ='admin';}