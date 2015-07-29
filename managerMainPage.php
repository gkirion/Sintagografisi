<?php

    //echo 'hello<br>';

    $tameio_id = $_POST["tameio_id"];
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
    $sql = "select * from tameio where id='$tameio_id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        ?>
        <table>
            <tr><td><form action="managerPliromes.htm"><button type="submit">Πληρωμές</button></form></td><td><form action="managerParakolouthisi.htm"><button type="submit">Παρακολούθηση</button></form></td></tr>
        </table>
        <?php
    }
    else {
        ?>
        <h3>Το ταμείο δεν υπάρχει</h3>
        <form action="managerTameioSearch.htm"><button type="submit">OK</button></form>
        <?php
    }
?>
