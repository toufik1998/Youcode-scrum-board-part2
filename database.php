<?php
    
    //CONNECT TO MYSQL DATABASE USING MYSQLI
    

    function connection(){
        $link = mysqli_connect("localhost", "root", "", "Youcodescumboard");

        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        // Print host information
        // echo "Connect Successfully. Host info: " . mysqli_get_host_info($link);

        return $link;
    }
       
?>