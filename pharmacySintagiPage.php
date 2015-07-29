<?php
    $sintagi_id = $_POST["sintagi_id"];
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
    $sql = "select * from sintagi where id=$sintagi_id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $sintagi_row = mysqli_fetch_assoc($result);
        ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>Untitled Page</title>
        <style type="text/css">
        table.tablesorter {
	font-family:arial;
	background-color: #CDCDCD;
	margin:10px 0pt 15px;
	font-size: 8pt;
	width: 100%;
	text-align: left;
        }
        table.price tr th {
            border-bottom: 1px solid black;
            border-collapse: collapse;
        }
        table.tablesorter thead tr th, table.tablesorter tfoot tr th {
                background-color: #e6EEEE;
                border: 1px solid #FFF;
                font-size: 8pt;
                padding: 4px;
        }
        table.tablesorter thead tr .header {
                background-repeat: no-repeat;
                background-position: center right;
                cursor: pointer;
        }
        table.tablesorter tbody td {
                color: #3D3D3D;
                padding: 4px;
                background-color: #FFF;
                vertical-align: top;
        }
        table.tablesorter tbody tr.odd td {
                background-color:#F0F0F6;
        }
        
        table.tablesorter thead tr .headerSortDown, table.tablesorter thead tr .headerSortUp {
        background-color: #8dbdd8;
        }        
        
    </style>
    <script type="text/javascript">
        function getData() {
            document.getElementById("pharmacy_id").value = sessionStorage.getItem("pharmacy_id");
            document.getElementById("sintagi_id").value = sessionStorage.getItem("sintagi_id");
        }
        
        function getFields() {
            document.getElementById("tameio").value = document.getElementById("tameio_id").innerHTML;
            document.getElementById("amount").value = document.getElementById("amount_id").innerHTML;
        }
    </script>
</head>
<body onload="getData()">

<table width="100%">
    <colgroup>
       <col span="1" style="width: 50%;">
       <col span="1" style="width: 50%;">
    </colgroup>
<tr><td>
<table>
    <tr><th colspan="2" align="left">Στοιχεία ιατρού</th></tr>
<?php 
    $sql = "select doctor.name, doctor.surname, doctor.address, doctor.email, doctor.phone, doctor.amka, doctor.tsay, doctor.speciality
            from doctor join visit on visit.doctor_tsay = doctor.tsay
            join sintagi on sintagi.visit_id = visit.id where sintagi.id = $sintagi_id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo "<tr><td>Όνομα:</td><td>" . $row["name"] . "</td></tr>";
        echo "<tr><td>Επίθετο:</td><td>" . $row["surname"] . "</td></tr>";
        echo "<tr><td>Τηλέφωνο:</td><td>" . $row["phone"] . "</td></tr>";
        echo "<tr><td>Διεύθυνση:</td><td>" . $row["address"] . "</td></tr>";
        echo "<tr><td>Email:</td><td>" . $row["email"] . "</td></tr>";
        echo "<tr><td>Ειδικότητα:</td><td>" . $row["speciality"] . "</td></tr>";
        echo "<tr><td>Τσαυ:</td><td id='tsay'>" . $row["tsay"] . "</td></tr>";
        echo "<tr><td>Άμκα:</td><td>" . $row["amka"] . "</td></tr>";
    }
?>
</table>
</td><td>
    <table >
        <tr><th colspan="2" align="left">Συνταγή</th></tr>
    <?php 
        echo "<tr><td>Id:</td><td>" . $sintagi_row["id"] . "</td></tr>";
        echo "<tr><td>Ημερομηνία ανοίγματος:</td><td>" . $sintagi_row["open_date"] . "</td></tr>";
        echo "<tr><td>Ημερομηνία λήξης:</td><td>" . $sintagi_row["expiration_date"] . "</td></tr>";
        echo "<tr><td>Αναγνωριστικό επίσκεψης:</td><td>" . $sintagi_row["visit_id"] . "</td></tr>";
    ?>
    </table>
</td><td>
    <table>
        <tr><th colspan="2" align="left">Στοιχεία ασθενούς</th></tr>
<?php 
    $sql = "select patient.name, patient.surname, patient.address, patient.email, patient.phone, patient.amka, patient.tameio
            from patient join visit on visit.patient_amka = patient.amka
            join sintagi on sintagi.visit_id = visit.id where sintagi.id = $sintagi_id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo "<tr><td>Άμκα:</td><td>" . $row["amka"] . "</td></tr>";
        echo "<tr><td>Όνομα:</td><td>" . $row["name"] . "</td></tr>";
        echo "<tr><td>Επίθετο:</td><td>" . $row["surname"] . "</td></tr>";
        echo "<tr><td>Τηλέφωνο:</td><td>" . $row["phone"] . "</td></tr>";
        echo "<tr><td>Διεύθυνση:</td><td>" . $row["address"] . "</td></tr>";
        echo "<tr><td>Email:</td><td>" . $row["email"] . "</td></tr>";
        echo "<tr><td>Ταμείο:</td><td id=\"tameio_id\">" . $row["tameio"] . "</td></tr>";
    }
?>
</table>
</td></tr>
<tr><td colspan="3">
<div id="demo" style="height: 200px; overflow:auto; width: 100%">
<table cellspacing="1" id="drug_table" class="tablesorter">
<thead>
<tr><th class="header">Id</th><th class="header">Όνομα</th><th class="header">Δραστική ουσία</th><th class="header">Ποσότητα</th><th class="header">Τιμή ανά τεμάχιο</th><th class="header">Συνολική τιμή</th><th class="header">Συμμετοχή ταμείου</th><th class="header">Τελική τιμή</th></tr>
</thead>
<tbody class="list">
<?php
    $sql = "select drug.id, drug.name, drug.drastiki_ousia, sintagi_drug.quantity, drug.price, sintagi_drug.quantity * drug.price as total_price, sintagi_drug.quantity * drug.price * tameio_drug.pososto_simmetoxis as simmetoxi_tameiou, sintagi_drug.quantity * drug.price - sintagi_drug.quantity * drug.price * tameio_drug.pososto_simmetoxis as final_price
            from drug join sintagi_drug on sintagi_drug.drug_id = drug.id
            join sintagi on sintagi.id = sintagi_drug.sintagi_id
            join visit on visit.id = sintagi.visit_id
            join patient on patient.amka = visit.patient_amka
            join tameio_drug on tameio_drug.tameio_id = patient.tameio and drug.id = tameio_drug.drug_id where sintagi.id = $sintagi_id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        while ($row) {
            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["drastiki_ousia"] . "</td><td>" . $row["quantity"] . "</td><td>" . $row["price"] . "</td><td>" . $row["total_price"] . "</td><td>" . $row["simmetoxi_tameiou"] . "</td><td>" . $row["final_price"] . "</td></tr>";
            $row = mysqli_fetch_assoc($result);
        }
    }
?>
</tbody>
</table>
</div>
</td></tr>
<tr><td colspan="3">
<table align="right" cellspacing="1" class="price">
<thead>
<tr><th colspan="3" class="header">Τιμή</th></tr>
</thead>
<tbody class="list" style="border: 1px solid black;">    
<?php 
    $sql = "select sum(sintagi_drug.quantity * drug.price) as total_price, sum(sintagi_drug.quantity * drug.price * tameio_drug.pososto_simmetoxis) as simmetoxi_tameiou, sum(sintagi_drug.quantity * drug.price - sintagi_drug.quantity * drug.price * tameio_drug.pososto_simmetoxis) as final_price 
            from drug join sintagi_drug on sintagi_drug.drug_id = drug.id
            join sintagi on sintagi.id = sintagi_drug.sintagi_id
            join visit on visit.id = sintagi.visit_id
            join patient on patient.amka = visit.patient_amka
            join tameio_drug on tameio_drug.tameio_id = patient.tameio and drug.id = tameio_drug.drug_id where sintagi.id = $sintagi_id";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                echo "<tr><td>Συνολική τιμή:</td><td>" . $row["total_price"] . "</td></tr>";
                echo "<tr><td>Συμμετοχή ταμείου:</td><td id=\"amount_id\">" . $row["simmetoxi_tameiou"] . "</td></tr>";
                echo "<tr><td>Τελική τιμή:</td><td>" . $row["final_price"] . "</td></tr>";
            }
?>
</tbody>
</table>
</td></tr>
<tr><td colspan="3">
        <table align="right"><tr><td>
        <form align="right" action="http://snf-655727.vm.okeanos.grnet.gr/PhpProject1/pharmacySintagiCompletePage.php" method="post">
            <input type="hidden" id="pharmacy_id" name="pharmacy_id" />
            <input type="hidden" id="sintagi_id" name="sintagi_id" />
            <input type="hidden" id="tameio" name="tameio" />
            <input type="hidden" id="amount" name="amount" />
            <button type="submit" onclick="getFields()">Ολοκλήρωση</button>
        </form>
        </td><td><form align="right" action="http://snf-655727.vm.okeanos.grnet.gr/PhpProject1/pharmacySintagiSearchPage.htm"><button type="submit">Ακύρωση</button></form>
        </td></tr></table>
</td></tr>
</table>
</body>
</html>

        <?php
    }
    else {
        ?>
        <h3>Δεν βρέθηκε συνταγή με αυτό το αναγνωριστικό</h3>
        <form action="pharmacySintagiSearchPage.htm"><button type="submit">OK</button></form>
        </body>
        </html>
        <?php
    }
?>
