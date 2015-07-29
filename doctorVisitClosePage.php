<?php
    $amka = $_POST["amka"];
    $tsay = $_POST["tsay"];
    $reason = $_POST["reason"];
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
    //echo "$amka<br>";
    //echo "$tsay<br>";
    //echo "$reason<br>";
    $sql = "insert into visit(open_date, reason, doctor_tsay, patient_amka) values(now(), '$reason', '$tsay', '$amka')";    
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $last_id = mysqli_insert_id($conn);
    }
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
            document.getElementById("visit_id").value = <?php echo "$last_id" ?>;
            sessionStorage.setItem("visit_id", <?php echo "$last_id" ?>);
        }

        function saveResult() {
            sessionStorage.setItem("results", document.getElementById("results").value);
        }
    </script>
</head>
<body onload="getData()">
<form action="http://snf-655727.vm.okeanos.grnet.gr/PhpProject1/doctorCompleteVisit.php" method="post">
<table>
<tr><td>Άμκα ασθενούς: </td><td><output id="amka" name="amka"></output></td></tr>
<tr><td>Όνομα: </td><td><output id="name" name="name"></output></td></tr>
<tr><td>Επίθετο: </td><td><output id="surname" name="surname"></output></td></tr>
<tr><td>Τηλέφωνο: </td><td><output id="phone" name="phone"></output></td></tr>
<tr><td>Διεύθυνση: </td><td><output id="address" name="address"></output></td></tr>
<tr><td>Email: </td><td><output id="email" name="email"></output></td></tr>
<tr><td>Ταμείο: </td><td><output id="tameio" name="tameio"></output></td></tr>
<tr><td>Λόγος επίσκεψης: </td><td><output id="reason" name="reason"></output></td></tr>
<tr><td>Αποτελέσματα: </td><td><input id="results" name="results" /></td></tr>
</table>
<input hidden="true" id="visit_id" name="visit_id"/>
<table>
<tr><td><button type="submit" onclick="saveResult()">Κλείσιμο επίσκεψης</button></td></form>
<td><form action="http://snf-655727.vm.okeanos.grnet.gr/PhpProject1/doctorSintagiPage.htm"><button type="submit">Νέα συνταγή</button></form></td>
<td><form action="http://snf-655727.vm.okeanos.grnet.gr/PhpProject1/doctorParapemptikoPage.htm"><button type="submit">Νέο παραπεμπτικό</button></form></td></tr>
</table>
</body>
</html>
