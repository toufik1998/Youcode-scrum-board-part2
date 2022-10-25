<?php
    
    //CONNECT TO MYSQL DATABASE USING MYSQLI
    

    function connection(){
        $conn = new mysqli("localhost", "root", "", "Youcodescumboard");

        if($conn->connect_error){
            die("Connection Failed" . $conn->connect_error);
        }

        return $conn;
    }
   

    // echo("connected seccuoiljqk");
    
?>