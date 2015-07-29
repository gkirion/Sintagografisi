<?php
    $visit_id = $_POST["visit_id"];
    $days = $_POST["days"];
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
    $sql = "insert into parapemptiko(open_date, expiration_date, visit_id) values(now(), now() + interval $days day, $visit_id)";    
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $last_id = mysqli_insert_id($conn);
    }
?>

﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
    <script type="text/javascript" src="http://snf-655727.vm.okeanos.grnet.gr/PhpProject1/jquery-latest.js"></script>
    <script type="text/javascript" src="http://snf-655727.vm.okeanos.grnet.gr/PhpProject1/jquery.tablesorter.js"></script>
    <script src="http://snf-655727.vm.okeanos.grnet.gr/PhpProject1/list.js"></script>
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
            document.getElementById("days").innerHTML = sessionStorage.getItem("parapemptiko_days");
            document.getElementById("parapemptiko_id").value = <?php echo "$last_id" ?>;
            sessionStorage.setItem("parapemptiko_id", <?php echo "$last_id" ?>);
        }
        
        function getRow(btn) {
            var id = btn.parentElement.parentElement.id;
            var data = document.getElementById(id).innerHTML.split("<td>")[1].split("</td>")[0];
            var table_data = "";
            var rows = parseInt(document.getElementById("rows").value);
            var ids = document.getElementsByName("exetasi_id[]");
            var quantities = document.getElementsByName("quantity[]");
            var reasons = document.getElementsByName("exetasi_reason[]");
            for (var i = 0; i < ids.length; i++) {
                table_data = table_data + "<tr id=\"" + i + "\"><td><input id=\"exetasi_id[]\" name=\"exetasi_id[]\" value=" + ids[i].value + "></td> \
                <td><input list=\"qlist\" id =\"quantity[]\" name=\"quantity[]\" size=\"4\" value=\"" + quantities[i].value + "\" required />\n\
                <datalist id=\"qlist\"> \n\
                <option value=\"1\"> \n\
                <option value=\"2\"> \n\
                <option value=\"3\"> \n\
                <option value=\"4\"> \n\
                </datalist></td> \n\
                <td><input type=\"text\" id=\"exetasi_reason[]\" name=\"exetasi_reason[]\" value=\"" + reasons[i].value + "\" /></td>\n\
                <td><button onclick=\"deleteRow(this)\">Διαγραφή</button></tr>";
            }
            table_data = table_data + "<tr id=\"" + ids.length + "\"><td><input id=\"exetasi_id[]\" name=\"exetasi_id[]\" value=" + data + "></td> \n\
            <td><input list=\"qlist\" id =\"quantity[]\" name=\"quantity[]\" size=\"4\" required /> \n\
            <datalist id=\"qlist\"> \n\
            <option value=\"1\"> \n\
            <option value=\"2\"> \n\
            <option value=\"3\"> \n\
            <option value=\"4\"> \n\
            </datalist></td> \n\
            <td><input type=\"text\" id=\"exetasi_reason[]\" name=\"exetasi_reason[]\" /></td>\n\
            <td><button onclick=\"deleteRow(this)\">Διαγραφή</button></tr>";
            document.getElementById("exetasi_list").innerHTML = table_data;
            rows = rows + 1;
            document.getElementById("rows").value = rows+"";
        }
        
        function deleteRow(btn) {
            var id = btn.parentElement.parentElement.id;
            var table_data = document.getElementById("exetasi_list").innerHTML;
            var row_data = document.getElementById(id).innerHTML;
            table_data = table_data.replace("<tr id=\"" + id + "\">" + row_data + "</tr>", "");
            document.getElementById("exetasi_list").innerHTML = table_data;
            var rows = parseInt(document.getElementById("rows").value);
            rows = rows - 1;
            document.getElementById("rows").value = rows+"";
        }
        $(document).ready(function() { 
            $("#exetasi_table").tablesorter({widgets: ['zebra']}); 
        }
        );
            
        var options = {
            valueNames: [ 'id', 'name', 'description', 'price' ]
        };
        
        var userList = new List('demo', options);  
        
        
        
        (function(document) {
	'use strict';

	var LightTableFilter = (function(Arr) {

		var _input;

		function _onInputEvent(e) {
			_input = e.target;
			var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
			Arr.forEach.call(tables, function(table) {
				Arr.forEach.call(table.tBodies, function(tbody) {
					Arr.forEach.call(tbody.rows, _filter);
				});
			});
		}

		function _filter(row) {
			var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
			row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
		}

		return {
			init: function() {
				var inputs = document.getElementsByClassName('light-table-filter');
				Arr.forEach.call(inputs, function(input) {
					input.oninput = _onInputEvent;
				});
			}
		};
	})(Array.prototype);

	document.addEventListener('readystatechange', function() {
		if (document.readyState === 'complete') {
			LightTableFilter.init();
		}
	});

})(document);
        
        
        
    </script>
</head>
<body onload="getData()">
<table width="100%">
    <colgroup>
       <col span="1" style="width: 50%;">
       <col span="1" style="width: 50%;">
    </colgroup>
    <tr><td>
<table><tr><th><h3>Παραπεμπτικό</h3></th></tr>
<tr><td>Έγκυρο για (ημέρες): <output id ="days" name="days"></output></td></tr></table>
</td>
<td><table>
<tr><td><h3>Επίσκεψη</h3></td></tr>
<tr><td>Άμκα ασθενούς: </td><td><output id="amka" name="amka"></output></td></tr>
<tr><td>Όνομα: </td><td><output id="name" name="name"></output></td></tr>
<tr><td>Επίθετο: </td><td><output id="surname" name="surname"></output></td></tr>
<tr><td>Τηλέφωνο: </td><td><output id="phone" name="phone"></output></td></tr>
<tr><td>Διεύθυνση: </td><td><output id="address" name="address"></output></td></tr>
<tr><td>Email: </td><td><output id="email" name="email"></output></td></tr>
<tr><td>Ταμείο: </td><td><output id="tameio" name="tameio"></output></td></tr>
<tr><td>Λόγος επίσκεψης: </td><td><output id="reason" name="reason"></output></td></tr>
</table></td>
</tr>
<tr><td>
<input type="search" class="light-table-filter" data-table="tablesorter" placeholder="Search">        
<div id="demo" style="height: 200px; overflow:auto;">
<table cellspacing="1" id="exetasi_table" class="tablesorter">
<thead>
<tr><th class="header">Id</th><th class="header">Όνομα</th><th class="header">Περιγραφή</th><th class="header">Τιμή</th><th class="header">Ενέργεια</th></tr>
</thead>
<tbody class="list">
<?php 
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
    $sql = "select * from exetasi";    
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $index = 1;
        while ($row) {
            $id = $row["id"];
            $name = $row["name"];
            $description = $row["description"];
            $price = $row["price"];
            $line = "";
            if ($index % 2) {
                $line = "odd";
            } 
            else {
                $line = "even";
            }
            echo "<tr id=\"row$index\" class=\"$line\"><td>$id</td><td>$name</td><td>$description</td><td>$price</td><td><button onclick=\"getRow(this)\">Εισαγωγή</button></td></tr>";
            $index++;
            $row = mysqli_fetch_assoc($result);
        }
    }
?>
</tbody>
</table>
</div></td>
<td>
<form action="http://snf-655727.vm.okeanos.grnet.gr/PhpProject1/doctorCompleteParapemptiko.php" method="post">
<div id="main" style="height: 200px; overflow: auto">
    <table style="margin: 10px 0pt 15px; border: 1px solid #FFF; font-size: 12pt; padding: 4px;">
    <tr><th>Id</th><th>Ποσότητα</th><th>Λόγος</th><th>Ενέργεια</th></tr>
    <tbody id="exetasi_list"></tbody>
</table>
</div>
</td>
</tr>
</table>
<input type="hidden" id="rows" name="rows" value="0"/>
<input type="hidden" id="parapemptiko_id" name="parapemptiko_id" />
<button type="submit">Ολοκλήρωση</button>
</form>
</body>
</html>
