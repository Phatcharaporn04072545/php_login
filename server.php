<?php
    $server = "localhost";
    $username = 'root';
    $password = '';
    $dbname = 'supply_hy';

    $conn = mysqli_connect($server, $username, $password, $dbname);


    if(!$conn) {
        die("Connection failed" . mysqli_connect_error());
    } else {
        echo "Connection sucessfully";
    }




?>
