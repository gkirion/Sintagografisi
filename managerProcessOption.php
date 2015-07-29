<?php
    $tameio = $_REQUEST["tameio"];
    $option = $_REQUEST["option"];
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
    $sql_sintagi = "select count(distinct sintagi.id) as arithmos_sintagon, count(distinct patient.amka) as arithmos_asthenon, sum(sintagi_drug.quantity * drug.price) as total_price, sum(sintagi_drug.quantity * drug.price * tameio_drug.pososto_simmetoxis) as simmetoxi_tameiou, sum(sintagi_drug.quantity * drug.price - sintagi_drug.quantity * drug.price * tameio_drug.pososto_simmetoxis) as final_price, Year(sintagi.open_date) as year 
                    from drug join sintagi_drug on sintagi_drug.drug_id = drug.id
                    join sintagi on sintagi.id = sintagi_drug.sintagi_id
                    join visit on visit.id = sintagi.visit_id
                    join patient on patient.amka = visit.patient_amka
                    join tameio_drug on tameio_drug.tameio_id = patient.tameio and drug.id = tameio_drug.drug_id
                    where tameio_drug.tameio_id = '$tameio' group by Year(sintagi.open_date)";
    
    $sql_parapemptiko = "select count(distinct parapemptiko.id) as arithmos_parapemptikon, count(distinct patient.amka) as arithmos_asthenon, sum(parapemptiko_exetasi.quantity * exetasi.price) as total_price, sum(parapemptiko_exetasi.quantity * exetasi.price * tameio_exetasi.pososto_simmetoxis) as simmetoxi_tameiou, sum(parapemptiko_exetasi.quantity * exetasi.price - parapemptiko_exetasi.quantity * exetasi.price * tameio_exetasi.pososto_simmetoxis) as final_price, Year(parapemptiko.open_date) as year
                        from exetasi join parapemptiko_exetasi on parapemptiko_exetasi.exetasi_id = exetasi.id
                        join parapemptiko on parapemptiko.id = parapemptiko_exetasi.parapemptiko_id
                        join visit on visit.id = parapemptiko.visit_id
                        join patient on patient.amka = visit.patient_amka
                        join tameio_exetasi on tameio_exetasi.tameio_id = patient.tameio and exetasi.id = tameio_exetasi.exetasi_id
                        where tameio_exetasi.tameio_id = '$tameio' group by Year(parapemptiko.open_date)";
    
    $sql_esoda = "select sum(amount) as amount, Year(payment.date) as year from payment where tameio_id='$tameio' group by Year(payment.date)";

	$sql_exoda = "select sum(amount) as amount, Year(date) as year from bill where tameio_id='$tameio' group by Year(date)";
    
    
    $sint_result = mysqli_query($conn, $sql_sintagi);
    $par_result = mysqli_query($conn, $sql_parapemptiko);
    header('Content-Type: text/xml; charset=utf-8');
    echo "<indexes>";
    if ($option == "isologismos") {
    	$esoda_result = mysqli_query($conn, $sql_esoda);
		$exoda_result = mysqli_query($conn, $sql_exoda);
        
        $esoda_row = mysqli_fetch_assoc($esoda_result);
		$exoda_row = mysqli_fetch_assoc($exoda_result);
        while ($esoda_row && $exoda_row) {
            $esoda = $esoda_row["amount"];
            $exoda = $exoda_row["amount"];
            $year = $esoda_row["year"];
            echo "<isologismos>
                    <year>$year</year>
                    <exoda>$exoda</exoda>
                    <esoda>$esoda</esoda>
                  </isologismos>";
        $esoda_row = mysqli_fetch_assoc($esoda_result);
		$exoda_row = mysqli_fetch_assoc($exoda_result);
        }
    }
    else if ($option == "D1") {
        $sint_row = mysqli_fetch_assoc($sint_result);
        $par_row =  mysqli_fetch_assoc($par_result);
        $snum_prev = "";
        $pnum_prev = "";
        while ($sint_row && $par_row) {
            $snum_curr = $sint_row["arithmos_sintagon"];
            $pnum_curr = $par_row["arithmos_parapemptikon"];
            if (($snum_prev != "") && ($pnum_prev != "")) {
                $d1_sintagi = $snum_curr / $snum_prev;
                $d1_parapemptiko = $pnum_curr / $pnum_prev;
                $year = $sint_row["year"];
                echo "<index>
                        <year>$year</year>
                        <sintagi>$d1_sintagi</sintagi>
                        <parapemptiko>$d1_parapemptiko</parapemptiko>
                      </index>";
            }
            $snum_prev = $snum_curr;
            $pnum_prev = $pnum_curr;
            $sint_row = mysqli_fetch_assoc($sint_result);
            $par_row =  mysqli_fetch_assoc($par_result);
        }
    }
    else if ($option == "D2") {
        $sint_row = mysqli_fetch_assoc($sint_result);
        $par_row =  mysqli_fetch_assoc($par_result);
        $scost_prev = "";
        $pcost_prev = "";
        while ($sint_row && $par_row) {
            $scost_curr = $sint_row["simmetoxi_tameiou"];
            $pcost_curr = $par_row["simmetoxi_tameiou"];
            if (($scost_prev != "") &&($pcost_prev != "")) {
                $d2_sintagi = ($scost_prev - $scost_curr) / $scost_prev;
                $d2_parapemptiko = ($pcost_prev - $pcost_curr) / $pcost_prev;
                $year = $sint_row["year"];
                echo "<index>
                        <year>$year</year>
                        <sintagi>$d2_sintagi</sintagi>
                        <parapemptiko>$d2_parapemptiko</parapemptiko>
                      </index>";
            }
            $scost_prev = $scost_curr;
            $pcost_prev = $pcost_curr;
            $sint_row = mysqli_fetch_assoc($sint_result);
            $par_row =  mysqli_fetch_assoc($par_result); 
        }
    }
    else {
        $sint_row = mysqli_fetch_assoc($sint_result);
        $par_row =  mysqli_fetch_assoc($par_result);
        $scost_prev = "";
        $pcost_prev = "";
        $snum_prev = "";
        $pnum_prev = "";
        while ($sint_row && $par_row) {
            $scost_curr = $sint_row["simmetoxi_tameiou"];
            $pcost_curr = $par_row["simmetoxi_tameiou"];
            $snum_curr = $sint_row["arithmos_asthenon"];
            $pnum_curr = $par_row["arithmos_asthenon"];
            if (($scost_prev != "") &&($pcost_prev != "")) {
                $d2_sintagi = ($scost_prev - $scost_curr) / $scost_prev;
                $d2_parapemptiko = ($pcost_prev - $pcost_curr) / $pcost_prev;
                $d3_sintagi = $d2_sintagi * ($snum_curr - $snum_prev);
                $d3_parapemptiko = $d2_parapemptiko * ($pnum_curr - $pnum_prev);
                $year = $sint_row["year"];
                echo "<index>
                        <year>$year</year>
                        <sintagi>$d3_sintagi</sintagi>
                        <parapemptiko>$d3_parapemptiko</parapemptiko>
                      </index>";
            }
            $scost_prev = $scost_curr;
            $pcost_prev = $pcost_curr;
            $snum_prev = $snum_curr;
            $pnum_prev = $pnum_curr;
            $sint_row = mysqli_fetch_assoc($sint_result);
            $par_row =  mysqli_fetch_assoc($par_result); 
        }
    }
    echo "</indexes>";
 ?>
