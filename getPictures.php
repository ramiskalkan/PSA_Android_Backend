<?php
/**
 * Created by PhpStorm.
 * User: Semih
 * Date: 14.12.2017
 * Time: 12:19
 */

if(isset($_GET["getPictures"])){
    require_once 'config.inc.php';
    $username = $_GET["getPictures"];
    checkPictures($username,$dsn,$user,$pass);

}


function checkPictures($email,$dsn,$user,$pass){
    try {
        $p_email = filter_var($email,FILTER_SANITIZE_EMAIL);

        $db = new PDO($dsn, $user, $pass);
        $sql = "SELECT pictures FROM user WHERE username=?";
        $stmt2= $db->prepare($sql);
        $stmt2->execute(array($p_email));

        $rows = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        if (!$rows) {
            echo NULL;
            exit;
        }

        //Alternative #3 - Using FetchAll
        $i = 1;
        foreach($rows as $row){
            if($row["pictures"]==NULL){
                echo "NULL";

            }else{
                print $row["pictures"];

            }
            $i++;
        }

        exit;
    } catch (Exception $ex) {
        print "$ex->getMessage()";
    }

}