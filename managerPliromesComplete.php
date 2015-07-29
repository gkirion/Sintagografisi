<?php

    //echo 'hello<br>';

    $tameio_id = $_POST["tameio_id"];
    $amount = $_POST["amount"];
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
   // echo "Connected successfully<br>";
    $sql = "insert into payment(date, amount, tameio_id) values(now(), $amount, '$tameio_id')";
    mysqli_query($conn, $sql);
    
?>

<html>
    <head>
        <title>Untitled</title>
    </head>
    <body>
        <table>
            <tr><td><form action="managerPliromes.htm"><button type="submit">Πληρωμές</button></form></td><td><form action="managerParakolouthisi.htm"><button type="submit">Παρακολούθηση</button></form></td></tr>
        </table>
    </body>
</html>
