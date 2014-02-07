<?php
if(ISSET($_GET["ce"])){
require("settings.php");    
$ce=$_GET["ce"]; 

    $msquery = "SELECT foto FROM CRED_Afiliados WHERE (ClaveElectoral='$ce')" ;
    $msresults=mssql_query($msquery);
            while($row=mssql_fetch_array($msresults)){
                header("Content-type: image/jpeg"); 
             echo $row['foto']; 
            }
 

}
?>