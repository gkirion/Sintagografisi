<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Manager Page</title>
    <style>

#header {
    background-color:white;
    color:white;
    text-align:right;
    padding:5px;
	border: 1px solid black;
	border-bottom: 2px solid black;
}
#nav {
    line-height:20px;
    background-color:#eeeeee;
    height:100%;
    width:250px;
    float:left;
    padding:5px;
}
#section {
    width:100%;
    float:left;
    /*padding:10px;*/	 	 
}
#non-floater 
{
    overflow:hidden;    
}
#footer {
    background-color:black;
    color:white;
    clear:both;
    text-align:center;
    padding:5px;	 	 
}
</style>
    </head>
    <body>
        <?php
            //echo 'hello<br>';
   
            $usr = $_POST["username"];
            $pwd = $_POST["password"];
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
            $sql = "select * from manager where amka='$usr' and password='$pwd'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                ?>
                <div id="header">
                <!--<h1>Medical I.S</h1>-->
				<table bgcolor="white" align="center" width="100%">
				<tr>
					<td> <img src="background.jpg" height="100px"  /> </td>
					<td><img align="middle" src="logo.jpg" height="100px" /> </td>
					<td><img align="right" src="decor.jpg" height="100px" /> </td>
				</tr>
				</table>
                </div>
                <div id="nav">
                <table>
                <tr><th colspan="2" align="left">Στοιχεία διαχειριστή</th></tr>
                <?php
                $row = mysqli_fetch_assoc($result);
                echo "<tr><td>Όνομα:</td><td>" . $row["name"] . "</td></tr>";
                echo "<tr><td>Επίθετο:</td><td>" . $row["surname"] . "</td></tr>";
                echo "<tr><td>Τηλέφωνο:</td><td>" . $row["phone"] . "</td></tr>";
                echo "<tr><td>Διεύθυνση:</td><td>" . $row["address"] . "</td></tr>";
                echo "<tr><td>Email:</td><td>" . $row["email"] . "</td></tr>";
                echo "<tr><td>Αμκα:</td><td>" . $row["amka"] . "</td></tr>";
                echo "<tr><td>Βαθμίδα:</td><td>" . $row["rank"] . "</td></tr>";
                ?>
                <tr><td><form action="http://snf-655727.vm.okeanos.grnet.gr/PhpProject1/managerLogin.htm"><button type="submit">Έξοδος</button></form></td></tr>
                </table>
                </div>
                <div id="non-floater">
                <div id="section">
                    <iframe width="100%" height="1000px" src="managerTameioSearch.htm" name="main_iframe"></iframe>
                </div>
                </div>
                <div id="footer">
                </div>
                <?php
            }
            else {
                ?>
                Λανθασμένο όνομα χρήστη και/η κωδικός<br />
                <form action="managerLogin.htm">
                <button type="submit">Πίσω</button>
                </form>
                <?php
            }
        ?>
    </body>
</html>
