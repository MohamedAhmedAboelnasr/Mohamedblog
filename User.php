<?php 
session_start();
$user=unserialize($_SESSION["user"]);
echo "welcome". $user->name;