<?php
    $parapemptiko_id = $_POST["parapemptiko_id"];
    $ids = $_POST["exetasi_id"];
    $quantities = $_POST["quantity"];
    $reasons = $_POST["exetasi_reason"];
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
    $index = 0;
    foreach ($ids as $id) {
        $sql = "insert into parapemptiko_exetasi(parapemptiko_id, exetasi_id, quantity, reason) values($parapemptiko_id, '$id', $quantities[$index], '$reasons[$index]')";    
        mysqli_query($conn, $sql);
        $index++;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Untitled Page</title>
    <style type="text/css">
        table.tablesorter {
	font-family:arial;
	background-color: #CDCDCD;
	margin:10px 0pt 15px;
	font-size: 8pt;
	width: 25%;
	text-align: left;
        }
        table.tablesorter thead tr th, table.tablesorter tfoot tr th {
                background-color: #e6EEEE;
                border: 1px solid #FFF;
                font-size: 8pt;
                padding: 4px;
        }
        table.tablesorter thead tr .header {
                background-image: url(bg.gif);
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
        table.tablesorter thead tr .headerSortUp {
                background-image: url(asc.gif);
        }
        table.tablesorter thead tr .headerSortDown {
                background-image: url(desc.gif);
        }
        table.tablesorter thead tr .headerSortDown, table.tablesorter thead tr .headerSortUp {
        background-color: #8dbdd8;
        }        
        
    </style>
    </head>
<body>
    <h3>Το παραπεμπτικό καταχωρήθηκε επιτυχώς</h3>
<table cellspacing="1" id="exetasi_table" class="tablesorter">
<thead>
<tr><th class="header">Id</th><th class="header">Ποσότητα</th><th class="header">Λόγος</th></tr>
</thead>
<tbody class="list">
    <?php
        $sql = "select * from parapemptiko_exetasi where parapemptiko_id='$parapemptiko_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            while ($row) {
                $exetasi_id = $row["exetasi_id"];
                $quantity = $row["quantity"];
                $reason = $row["reason"];
                echo "<tr><td>$exetasi_id</td><td>$quantity</td><td>$reason</td></tr>";
                $row = mysqli_fetch_assoc($result);
            }
        } 
    ?>
</tbody>
</table>
    <form action="http://snf-655727.vm.okeanos.grnet.gr/PhpProject1/doctorVisitClosePage.htm">
        <button type="submit">OK</button>
    </form>
</body>
</html>
