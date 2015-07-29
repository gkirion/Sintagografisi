<?php
    $amka = $_REQUEST["amka"];
    $servername = "localhost";
    $username = "root";
    $password = "cskir88";
    $database = "sintagografisi";
    
    // Create connection 
    $conn = mysqli_connect($servername, $username, $password, $database);
    mysqli_set_charset($conn,"utf8");
    // Check connection
    if (!$conn) { 
        die("Connection failed: " . mysqli_connect_error());
    }    
    //echo "Connected successfully<br>";    
    $sql = "select * from patient where amka='$amka'";    
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row["name"];
        $surname = $row["surname"];
        $phone = $row["phone"];
        $address = $row["address"];
        $email = $row["email"];
        $tameio = $row["tameio"];
        header('Content-Type: text/xml; charset=utf-8');
        echo "<catalog>
            <patient>
                <name>$name</name>
                <surname>$surname</surname>
                <phone>$phone</phone>
                <address>$address</address>
                <email>$email</email>
                <amka>$amka</amka>
                <tameio>$tameio</tameio>
            </patient>
         </catalog>";
    }
    else {
        echo "not found";
    }
?>
