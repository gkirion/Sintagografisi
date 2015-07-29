<?php
    $exetastiko_kentro_id = $_POST["exetastiko_kentro_id"];
    $parapemptiko_id = $_POST["parapemptiko_id"];
    $tameio = $_POST["tameio"];
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
    //echo "Connected successfully<br>";
	$sql = "select * from parapemptiko where id=$parapemptiko_id and exetastiko_kentro_id is NULL";
 	$result = mysqli_query($conn, $sql);
?>
﻿<!DOCTYPE html>
<html>
<head>
    <title>Untitled Page</title>
</head>
<body>
<?php
	if (mysqli_num_rows($result)) {
    	$sql = "update parapemptiko set exetastiko_kentro_id='$exetastiko_kentro_id' where id=$parapemptiko_id";
    	mysqli_query($conn, $sql);
    	$sql = "insert into bill(date, amount, tameio_id) values(now(), $amount, '$tameio')";
    	mysqli_query($conn, $sql);
?>
		<h3>Το παραπεμπτικό θεωρήθηκε επιτυχώς</h3>
<?php
	}
	else {
?>
		<h3>Το παραπεμπτικό έχει ήδη θεωρηθεί</h3>
<?php
	}
?>
<form action="http://snf-655727.vm.okeanos.grnet.gr/PhpProject1/exetasiSearchPage.htm" method="post">
<button type="submit">Επιστροφή</button>
</form>
</body>
</html>
