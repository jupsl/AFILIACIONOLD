<?php
if(ISSET($_GET["ce"])){
    require_once("bin/controler.php");
    $db=new dbManager();
    $reporte=$db->getCredencial($_GET["ce"]);
    $Nombre=$reporte[0];
    $Domicilio=$reporte[1];
    $Colonia=$reporte[2];
    $Sexo=$reporte[3];
    $ClaveElectoral=$reporte[4];
    $DistritoFederal=$reporte[5];
    $DistritoLocal=$reporte[6];
    $Seccion=$reporte[7];
    $municipio=$reporte[8];
    $sectorg=$reporte[9];
    $fecha=$reporte[10];
    $cargo=$reporte[11];
?>
<style type="text/css">
  .dato {
    font-size:10px;
    font-family: sans-serif;
    font-weight: bold;
    }
    .dato1 {
    font-size:9px;
    font-family: sans-serif;
    font-weight: bold;
    }
    .titulo {
        font-size:9px;
    font-family: sans-serif;
    }
  </style>
<table width="340" heigt="250" >
    <tr>
        <td></td>
    </tr>
</table>
<img src="images/frontal.png"  STYLE="position:absolute; top:0px; left:0px; width:345px; height:220px; visibility:visible z-index:1" />
<img src="bin/ver_foto.php?ce=<?php echo($_GET["ce"]); ?>" STYLE="position:absolute; top:70px; left:5px; width:80px; height:100px; visibility:visible z-index:2" />
<?php
if($sectorg=="CNC"){

?><img src="images/cnc.png" STYLE="position:absolute; top:1px; left:260px; width:50px; height:50px; visibility:visible z-index:2" />
<?php
}else if($sectorg=="CTM"){
    ?><img src="images/ctm.png" STYLE="position:absolute; top:1px; left:260px; width:50px; height:50px; visibility:visible z-index:2" />
<?php
}else if($sectorg=="CNOP"){
    ?><img src="images/cnop.png" STYLE="position:absolute; top:1px; left:260px; width:50px; height:50px; visibility:visible z-index:2" />
<?php
}else if($sectorg=="MT"){
    ?><img src="images/mt.png" STYLE="position:absolute; top:1px; left:260px; width:50px; height:50px; visibility:visible z-index:2" />
<?php
}else if($sectorg=="FJR"){
    ?><img src="images/fjr.png" STYLE="position:absolute; top:1px; left:260px; width:50px; height:50px; visibility:visible z-index:2" />
<?php
}else if($sectorg=="ONMPRI"){
    ?><img src="images/onmpri.png" STYLE="position:absolute; top:1px; left:260px; width:50px; height:50px; visibility:visible z-index:2" />
<?php
}else if($sectorg=="F.COLOSIO"){
    ?><img src="images/colosio.png" STYLE="position:absolute; top:1px; left:260px; width:50px; height:50px; visibility:visible z-index:2" />
<?php
}else if($sectorg=="ICADEP"){
    ?><img src="images/icadep.png" STYLE="position:absolute; top:1px; left:260px; width:50px; height:50px; visibility:visible z-index:2" />
<?php
}else if($sectorg=="ANUR"){
    ?><img src="images/anur.png" STYLE="position:absolute; top:1px; left:260px; width:50px; height:50px; visibility:visible z-index:2" />
<?php
}else if($sectorg=="IPE"){
    ?><img src="images/ipe.png" STYLE="position:absolute; top:1px; left:260px; width:50px; height:50px; visibility:visible z-index:2" />
<?php
}
?>
<span class="dato" STYLE="position:absolute; top:55px; left:5px;  visibility:visible z-index:3"><?php echo($Nombre); ?></span>
<span class="titulo" STYLE="position:absolute; top:70px; left:88px;  visibility:visible z-index:3">DOMICILIO</span>
<span class="dato" STYLE="position:absolute; top:83px; left:88px;  visibility:visible z-index:3"><?php echo($Domicilio); ?></span>
<span class="dato" STYLE="position:absolute; top:98px; left:88px;  visibility:visible z-index:3"><?php echo($Colonia); ?></span>
<span class="titulo" STYLE="position:absolute; top:110px; left:88px;  visibility:visible z-index:3">CLAVE DE ELECTOR</span>
<span class="dato" STYLE="position:absolute; top:110px; left:183px;  visibility:visible z-index:3"><?php echo($ClaveElectoral); ?></span>
<span class="titulo" STYLE="position:absolute; top:122px; left:88px;  visibility:visible z-index:3">DTO.FED.</span>
<span class="dato" STYLE="position:absolute; top:122px; left:135px;  visibility:visible z-index:3"><?php echo($DistritoFederal); ?></span>
<span class="titulo" STYLE="position:absolute; top:122px; left:160px;  visibility:visible z-index:3">DTO.LOC.</span>
<span class="dato" STYLE="position:absolute; top:122px; left:215px;  visibility:visible z-index:3"><?php echo($DistritoLocal); ?></span>
<span class="titulo" STYLE="position:absolute; top:122px; left:245px;  visibility:visible z-index:3">SECCION</span>
<span class="dato" STYLE="position:absolute; top:122px; left:290px;  visibility:visible z-index:3"><?php echo($Seccion); ?></span>
<span class="titulo" STYLE="position:absolute; top:135px; left:88px;  visibility:visible z-index:3">MUNICIPIO</span>
<span class="dato" STYLE="position:absolute; top:135px; left:140px;  visibility:visible z-index:3"><?php echo(strtoupper($municipio)); ?></span>

<span class="titulo" STYLE="position:absolute; top:148px; left:88px;  visibility:visible z-index:3">ENTIDAD</span>

<span class="dato" STYLE="position:absolute; top:148px; left:135px;  visibility:visible z-index:3">08</span>
<?php /*if($cargo!="NINGUNO"){ ?>
<span class="titulo" STYLE="position:absolute; top:158px; left:88px;  visibility:visible z-index:3">CARGO</span>
<span class="dato" STYLE="position:absolute; top:158px; left:135px;  visibility:visible z-index:3"><?php echo($cargo); ?></span>
<?php }*/
?>
<span class="dato1" STYLE="position:absolute; top:180px; left:6x;  visibility:visible z-index:3">Fecha de Afiliacion</span>
<?php
$fecha=substr($fecha,0,11);
$fecha=str_replace("Jan","Ene",$fecha);
$fecha=str_replace("Jan","Ene",$fecha);
$fecha=str_replace("Apr","Abr",$fecha);
$fecha=str_replace("Aug","Ago",$fecha);
$fecha=str_replace("Dec","Dic",$fecha);
?>
<span class="titulo" STYLE="position:absolute; top:180px; left:120px;  visibility:visible z-index:3"><?php echo($fecha); ?></span>
<span class="titulo" STYLE="position:absolute; top:70px; left:245px;  visibility:visible z-index:3">GENERO</span>
<span class="dato" STYLE="position:absolute; top:70px; left:290px;  visibility:visible z-index:3"><?php echo($Sexo); ?></span>
<?php
//$estampa = $db->newimage("bin/ver_foto.php?ce=".$_GET["ce"]);

}
?>
