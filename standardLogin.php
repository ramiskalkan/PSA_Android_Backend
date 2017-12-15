<?php
/**
 * Created by PhpStorm.
 * User: Semih
 * Date: 14.12.2017
 * Time: 02:56
 */



if(isset($_POST["standardLogin"])){
    require_once 'config.inc.php';

    $data = $_POST["standardLogin"];

    list($username,$password)= explode('_',$data);

    try {
        $db = new PDO($dsn, $user, $pass);

        if(login($username,$password,$dsn,$user,$pass)){
            echo "SUCCESS"; //EMAIL AND PASSWORD CORRECT
            exit;
        }else{
            echo "Email or password is incorrect";
            exit;
        }
    } catch (Exception $ex) {
        print "$ex->getMessage()";
    }

}




function login($email,$password,$dsn,$user,$pass) {
    try {
        $p_email = filter_var($email,FILTER_SANITIZE_EMAIL);
        $p_password= filter_var($password,FILTER_SANITIZE_STRING);

        $db = new PDO($dsn, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $sql2= "select * from user where username=? AND password=?";
        $stmt2= $db->prepare($sql2);
        $stmt2->execute(array($p_email,sha1($p_password.":salt")));
        $row = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        if ($row) { //Success
            return true;
        }

    } catch (Exception $ex) {
        print "$ex->getMessage()";
    }
    return false;
}

if(isset($_POST["displayUsers"])){
    displayAllUsers($dsn,$user,$pass);
}