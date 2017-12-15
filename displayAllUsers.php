<?php
/**
 * Created by PhpStorm.
 * User: Semih
 * Date: 14.12.2017
 * Time: 12:33
 */

require_once 'config.inc.php';


displayAllUsers($dsn,$user,$pass);


function displayAllUsers($dsn,$user,$pass){
    try {
        $db = new PDO($dsn, $user, $pass);
        $sql = "SELECT username, pictures FROM user";
        $rs = $db->query($sql);
        if(!$rs){
            print "<p>Query Error: ". print_r($db->errorInfo(),true)
                . "</p>";
            exit;
        }

        $numRow = $rs->rowCount();
        echo "<p>Total: ".$numRow. "</p>";

        //Alternative #3 - Using FetchAll
        $i = 1;
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row){
            print "<p> $i. " .$row["username"]." " .$row["pictures"]. " </p>";
            $i++;
        }

    } catch (Exception $ex) {
        print "$ex->getMessage()";
    }
}