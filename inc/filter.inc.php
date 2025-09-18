<?php
function domainFilter(){
    if(isset($_GET['filter'])){
        $filter = $_GET['filter'];
        $sql = "SELECT * FROM domini WHERE disponibile = '$filter'";
    } else {
        $sql = "SELECT * FROM domini";
    }
    return $sql;
}

