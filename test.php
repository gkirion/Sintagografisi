<?php
    $ids = $_POST["drug_id"];
    $quantities = $_POST["quantity"];
    $reasons = $_POST["drug_reason"];
    $index = 0;
    foreach ($ids as $id) {
        echo "$id   $quantities[$index]    $reasons[$index]</br>";
        $index++;
    }
?>
