<?php
    $results = $_POST["results"];
    $visit_id = $_POST["visit_id"];
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
    $sql = "update visit set results='$results', closed_date=now() where id=$visit_id";    
    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>Untitled Page</title>
    <script type="text/javascript">
        function getData() {
            document.getElementById("amka").innerHTML = sessionStorage.getItem("amka");
            document.getElementById("name").innerHTML = sessionStorage.getItem("name");
            document.getElementById("surname").innerHTML = sessionStorage.getItem("surname");
            document.getElementById("email").innerHTML = sessionStorage.getItem("email");
            document.getElementById("reason").innerHTML = sessionStorage.getItem("reason");
            document.getElementById("tameio").innerHTML = sessionStorage.getItem("tameio");
            document.getElementById("phone").innerHTML = sessionStorage.getItem("phone");
            document.getElementById("address").innerHTML = sessionStorage.getItem("address");
            document.getElementById("results").innerHTML = sessionStorage.getItem("results");
        }
    </script>
</head>
<body onload="getData()">
<h2>Η επίσκεψη καταχωρήθηκε επιτυχώς</h2>
<form action="http://snf-655727.vm.okeanos.grnet.gr/PhpProject1/doctorVisitOpenPage.htm" method="post">
<table>
<tr><td>Άμκα ασθενούς: </td><td><output id="amka" name="amka"></output></td></tr>
<tr><td>Όνομα: </td><td><output id="name" name="name"></output></td></tr>
<tr><td>Επίθετο: </td><td><output id="surname" name="surname"></output></td></tr>
<tr><td>Τηλέφωνο: </td><td><output id="phone" name="phone"></output></td></tr>
<tr><td>Διεύθυνση: </td><td><output id="address" name="address"></output></td></tr>
<tr><td>Email: </td><td><output id="email" name="email"></output></td></tr>
<tr><td>Ταμείο: </td><td><output id="tameio" name="tameio"></output></td></tr>
<tr><td>Λόγος επίσκεψης: </td><td><output id="reason" name="reason"></output></td></tr>
<tr><td>Αποτελέσματα: </td><td><output id="results" name="results"></output></td></tr>
</table>
<button type="submit">OK</button>
</form>
</body>
</html>
