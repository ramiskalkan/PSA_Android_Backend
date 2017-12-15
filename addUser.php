<?php
/**
 * Created by PhpStorm.
 * User: Semih
 * Date: 13.12.2017
 * Time: 22:25
 */


if(isset($_POST["register"])){
    require_once 'config.inc.php';

    $data = $_POST["register"];

    list($username,$password,$repassword)= explode('_',$data);

    try {
        $db = new PDO($dsn, $user, $pass);

        //Check password length

        $p_password= filter_var($p_password,FILTER_SANITIZE_STRING);
        $p_password2= filter_var($p_password2,FILTER_SANITIZE_STRING);

        if(strlen($p_password)<5){
            echo "Your password must be at least 5 characters";
            exit;
        }

        if($p_password!=$p_password2){
            echo "Your password must match with repassword";
            exit;
        }

        //DELETING THE LESS THAN GREATER THAN SYMBOLS
        $p_email= filter_var($username,FILTER_SANITIZE_EMAIL);
        $reg_email="/^\w{4,30}@([a-z]{1,15}\.){1,2}(com|net)$/";
        if(preg_match($reg_email,$p_email)==false){
            echo "You must write correct e-mail address";
            exit;
        }


        if(isUserExist($username,$password,$dsn,$user,$pass)){
            echo "User has already exist";
        }else{
            echo "You Successfully registered into PSA System";
        }
        exit;

    } catch (Exception $ex) {
        print "$ex->getMessage()";
    }

}



function isUserExist($email,$password,$dsn,$user,$pass) {
    try {
        $db = new PDO($dsn, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql2= "select * from user where username=?";
        $stmt2= $db->prepare($sql2);
        $stmt2->execute(array($email));
        $row = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        if ($row) { //Kullanıcı var
            return true;
        }else{ //Kullanıcı yoksa
            $sql= "insert into user (username,password,pictures) values(?,?,?)";
            $stmt = $db->prepare($sql);
            $stmt->execute(array($email, sha1($password . ":salt"),NULL));

        }

    } catch (Exception $ex) {
        print "$ex->getMessage()";
    }
    return false;
}

if(isset($_POST["displayUsers"])){
    displayAllUsers($dsn,$user,$pass);
}




?>
