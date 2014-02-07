<?php
    ini_set('mssql.charset', 'UTF-8');
    $msconect = mssql_connect("192.168.1.35","sw","kxetADM97");
    $smsdb=mssql_select_db("PRINET_DESARROLLO",$msconect);
    //$personas="192.168.1.35";
     
?>