<?php
    $pharmacy_id = $_POST["pharmacy_id"];
    $sintagi_id = $_POST["sintagi_id"];
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
	$sql = "select * from sintagi where id=$sintagi_id and pharmacy_id is NULL";
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
    	$sql = "update sintagi set pharmacy_id='$pharmacy_id' where id=$sintagi_id";
    	mysqli_query($conn, $sql);
 		$sql = "insert into bill(date, amount, tameio_id) values(now(), $amount, '$tameio')";
		mysqli_query($conn, $sql);
?>
		<h3>Η συνταγή θεωρήθηκε επιτυχώς</h3>
<?php
	}
	else {
?>
		<h3>Η συνταγή έχει ήδη θεωρηθεί</h3>
<?php		
	}
?>
<form action="http://snf-655727.vm.okeanos.grnet.gr/PhpProject1/pharmacySintagiSearchPage.htm" method="post">
<button type="submit">Επιστροφή</button>
</form>
</body>
</html>
