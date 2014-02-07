<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 5//EN"
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 5//EN"
    "http://www.w3.org/TR/html5/html5.dtd"
    >
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Alta</title>
<link href="menu_source/styles.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
    
    <?php
    require_once("menu.php");?><br/><?php
    //echo(md5("CHIHUAHUA"));
    require_once("bin/controler.php");
    $db=new dbManager();
   $db->configuracion("altas.php");
    // Area de Configuracion
    if(ISSET($_COOKIE["message"])){
        ?><center><h2><?php echo($_COOKIE["message"]); ?></h2></center><?php
        setcookie("message","");
    }
    if(ISSET($_COOKIE["CRED"])){
        ?>
        <center><a href="get_cred.php?ce=<?php echo($_COOKIE["CRED"]); ?>" target="_BLANK">Imprimir Credencial</a></center>
        <?php
        setcookie("CRED","");
    }
    if(ISSET($_POST["cancel"])){
        $db->borraCokkiesAfiliado();
             header("Location:altas.php");
    }
    if(ISSET($_POST["guardar"])){
        $message="";
        $valida=true;
        //valida Sexo
         if(!$db->valida($_POST["sexo"],false)){
            $valida=false;
            $message="genero No Valido";
        }
        //valida Seccion
        if(!$db->valida($_POST["idseccion"],true)){
            $valida=false;
            $message="Seccion No Valida";
        }
        //validar Sector Org
        if(!$db->valida($_POST["sectororg"],true)){
            $valida=false;
            $message="Seccion No Valida";
        }
        //validar foto
        if(ISSET($_COOKIE["myimage"])){
            $_POST["foto"]=$_COOKIE["myimage"];
        }
        if(!$db->valida($_POST["foto"],false)){
            $valida=false;
            $message="foto No Valida";
        }
        $folio=$db->dameFolio($_COOKIE["ceAfiliado"]);
        if($folio==""){
        //validar init folio
        if(!$db->valida($_POST["initfolio"],true)){
            $valida=false;
            $message="folio no valido";
        }
        //validar folio
        if(!$db->valida($_POST["folio"],true)||$_POST["folio"]==""){
            $valida=false;
            $message="folio No Valido";
        }
        
        //Validar Folio
        $folio=$db->formatoFolio($_POST["initfolio"],$_POST["folio"]);
        if(!$db->validaFolio($folio)){
            $valida=false;
            $message="El Folio: $folio No Existe o esta siendo ocupado por otra persona";
        }
        }
        if($valida==true){
            
            //si ya esta afiliado
            if($db->esAfiliado($_COOKIE["ceAfiliado"])){
                //si hay foto
                
                    $db->updateAfiliado($_COOKIE["paternoAfiliado"],$_COOKIE["maternoAfiliado"],$_COOKIE["nomAfiliado"],$_COOKIE["calleAfiliado"],$_COOKIE["numextAfiliado"],$_COOKIE["numintAfiliado"],$_COOKIE["coloniaAfiliado"],$_COOKIE["idcargoAfiliado"],$_POST["idseccion"],$_POST["sectororg"],$_COOKIE["cpAfiliado"],$folio,$_COOKIE["IDAFI"],$_COOKIE["ceAfiliado"],$_POST["sexo"]);
                
                
            }else{//si es nuevo
                $db->agregaAfiliado($_COOKIE["paternoAfiliado"],$_COOKIE["maternoAfiliado"],$_COOKIE["nomAfiliado"],$_COOKIE["calleAfiliado"],$_COOKIE["numextAfiliado"],$_COOKIE["numintAfiliado"],$_COOKIE["coloniaAfiliado"],$_COOKIE["ceAfiliado"],$_POST["idseccion"],$_COOKIE["cpAfiliado"],$_COOKIE["IDAFI"],$_POST["sectororg"],$folio,$_COOKIE["idcargoAfiliado"],$_POST["sexo"]);
                
            }
            $message="Agregado Correctamente";
            //Actualizar Foto
             if($_POST["foto"]!=""){
                $db->updateFoto($_COOKIE["ceAfiliado"],$_POST["foto"]);
             }
            //Actualizar el Folio cuando ya se agrego el afiliado
            
            $db->actualizaFolio($_COOKIE["ceAfiliado"],$folio);
      setcookie("CRED",$_COOKIE["ceAfiliado"]);
      $db->borraCokkiesAfiliado();
     setcookie("message",$message);
      header("Location:altas.php");
        }else{
              ?><center><h2><?php echo($message); ?></h2></center><?php
             ?><center><a href="javascript:history.back(1)">Regresar</a></center><?php
        }
    }
    if(ISSET($_POST["ap"])){
        
        $valida=true;
        $message="";
        //----------Validacion
        if(!$db->valida($_POST["n"],false)){
            $valida=false;
            $message="Nombre No Válido";
        }
        if(!$db->valida($_POST["ap"],false)){
            $valida=false;
            $message="Nombre No Válido";
        }
        if(!$db->valida($_POST["am"],false)){
            $valida=false;
            $message="Nombre No Válido";
        }
        if(!$db->valida($_POST["calle"],false)){
            $valida=false;
            $message="calle No Válida";
        }
        if(!$db->valida($_POST["numext"],false)){
            $valida=false;
            $message="numext No Válido";
        }
        if(!$db->valida($_POST["numint"],false)){
            $valida=false;
            $message="numint No Válido";
        }
        if(!$db->valida($_POST["colonia"],false)){
            $valida=false;
            $message="colonia No Válido";
        }
        if(!$db->valida($_POST["idmun"],true)){
            $valida=false;
            $message="idmun No Válido";
        }
        if(!$db->valida($_POST["ce"],false)||(!$db->validaClaveElectoral($_POST["ce"]))){
            
            $valida=false;
            $message="clave electoral No Válida";
        }
        if(!$db->valida($_POST["cp"],false)){
            
            $valida=false;
            $message="Codigo Postal No Valido";
        }
        //------
        if(ISSET($_POST["casa"]))
        if($_POST["casa"]!="")
        if($_POST["casa"]!="")
        if(!$db->valida($_POST["casa"],true)){
            $valida=false;
            $message="casa No Válido";
        }
        if(ISSET($_POST["celular"]))
        if($_POST["celular"]!="")
        if($_POST["celular"]!="")
        if(!$db->valida($_POST["celular"],true)){
            $valida=false;
            $message="cel No Válido";
        }
        if(!$db->valida($_POST["email"],false)){
            $valida=false;
            $message="mail No Válido";
        }
        if(!$db->valida($_POST["idcargo"],true)){
            $valida=false;
            $message="cargo No Válido";
        }
        
        if($valida==true){
            //$idseccion=$db->getIdSeccion($_POST["ce"]);
            setcookie("nomAfiliado",strtoupper($_POST["n"]));
            setcookie("paternoAfiliado",strtoupper($_POST["ap"]));
            setcookie("maternoAfiliado",strtoupper($_POST["am"]));
            setcookie("calleAfiliado",strtoupper($_POST["calle"]));
            setcookie("numextAfiliado",strtoupper($_POST["numext"]));
            setcookie("numintAfiliado",strtoupper($_POST["numint"]));
            setcookie("coloniaAfiliado",strtoupper($_POST["colonia"]));
            setcookie("ceAfiliado",strtoupper($_POST["ce"]));
            setcookie("idcargoAfiliado",$_POST["idcargo"]);
             setcookie("cpAfiliado",$_POST["cp"]);
               // $db->altaPersona($_POST["n"],$_POST["ap"],$_POST["am"],strtoupper($_POST["calle"]),$_POST["numext"],$_POST["numint"],$_POST["colonia"],$_POST["idmun"],$idseccion,$_POST["ce"],$_COOKIE["CARGO"],"1","NULL",$_COOKIE["IDCPE"]);
           
            $db->datosPersonales($_POST["casa"],$_POST["celular"],$_POST["mail"],$_POST["ce"]);
         setcookie("CARGO","");
         setcookie("MUNA","");
        setcookie("TIPOCARGO","");
        setcookie("TIPOC","");
       // setcookie("message","Agregado Correctamente");
        header("Location:altas.php");
        }else{
             ?><center><h2><?php echo($message); ?></h2></center><?php
             ?><center><a href="javascript:history.back(1)">Regresar</a></center><?php
        }
    }
    //movimientos de validacion
    

    

    

    //Area de Vistas

                //de aqui empieza el show de afiliados--------------------
                if(!ISSET($_COOKIE["paternoAfiliado"])){
                   ?>
                   <center>
                    <h2>Buscar Persona</h2>
                  
                    <form action="altas.php" method="post">
                        Paterno&nbsp;<input type="text" name="paterno" />&nbsp;Materno&nbsp;<input type="text" name="materno"/>&nbsp;Nombre&nbsp;<input type="text" name="nombre" /><br/><br/>
                        <input type="submit"  class="button" value="Buscar"/>
                    </form>
                    <br/> <br/>
                    
                    <?php
                    if(ISSET($_POST["paterno"])){
                         $padron=$db->getFromPadron($_POST["paterno"],$_POST["materno"],$_POST["nombre"]);
                    $APELLIDO_PATERNO=explode(",",$padron[0]);
                $APELLIDO_MATERNO=explode(",",$padron[1]);
                $NOMBRE=explode(",",$padron[2]);
                $CLAVE_ELECTORAL=explode(",",$padron[3]);
                $NOMBRE_MUNICIPIO=explode(",",$padron[4]);
                $CALLE=explode(",",$padron[5]);
                $NUMERO_EXTERIOR=explode(",",$padron[6]);
                $NUMERO_INTERIOR=explode(",",$padron[7]);
                $COLONIA=explode(",",$padron[8]);
                $CASA=explode(",",$padron[9]);
                $CELULAR=explode(",",$padron[10]);
                $email=explode(",",$padron[11]);
                $IdMunicipio=explode(",",$padron[12]);
                $idcargosb=explode(",",$padron[13]);
                 $cp=explode(",",$padron[14]);
                 $cargos=$db->getCargos();
                                $idcargos=explode(",",$cargos[0]);
                                $desccargos=explode(",",$cargos[1]);
                ?>
                <table border="1">
                   
                        
                        
                    
                    <?php
                    if($CLAVE_ELECTORAL[0]!=""){
                       
                                
                    for($i=0;$i<count($CLAVE_ELECTORAL);$i++){
                        ?>
                        <form action="altas.php" method="post">
                         <tr>
                            <th rowspan="4"><img src="bin/ver_foto.php?ce=<?php echo($CLAVE_ELECTORAL[$i]); ?>" width="150" height="150" alt="no image"/></th>
                        <th style="color:black;">Nombre</th>
                        <td colspan="4"><center><?php echo($APELLIDO_PATERNO[$i]." ".$APELLIDO_MATERNO[$i]." ".$NOMBRE[$i]); ?>
                        <input type="hidden" name="ap" value="<?php echo($APELLIDO_PATERNO[$i]); ?>"/>
                             <input type="hidden" name="am" value="<?php echo($APELLIDO_MATERNO[$i]); ?>"/>
                              <input type="hidden" name="n" value="<?php echo($NOMBRE[$i]); ?>"/></center>
                        </td>
                         </tr>
                         <tr>
                        
                        <th style="color:black;">Clave Electoral</th>
                        <td colspan="4"><center><?php echo($CLAVE_ELECTORAL[$i]); ?><input type="hidden" name="ce" value="<?php echo($CLAVE_ELECTORAL[$i]); ?>"/></td>
                         </center>
                         </tr>
                         <tr>
                            <th style="color:black;">Cargo</th><td colspan="3"><select name="idcargo">
                                <?php
                                for($j=0;$j<count($idcargos);$j++){
                                    ?><option value="<?php echo($idcargos[$j]); ?>"<?php if($idcargosb[$i]==$idcargos[$j]){echo(" selected='true' ");}
                                    ?>
                                    ><?php echo($desccargos[$j]); ?></option><?php
                                }
                                ?>
                            </select></td>
                         </tr>
                        <tr>
                            
                            <th style="color:black;" colspan="4" ><center>Datos Personales</center></th>
                               
                        </tr>
                        <tr>
                            <th style="color:black;"><center>Municipio</center></th>
                        <th style="color:black;"><center>Calle</center></th>
                        <th style="color:black;"><center>Num Exterior</center></th>
                        <th style="color:black;"><center>Num Interior</center></th>
                        <th style="color:black;"><center>Colonia</center></th>
                        </tr>
                        <tr>
                                <td><center><?php echo($NOMBRE_MUNICIPIO[$i]); ?></center></td>
                                 <td><center><input type="text" name="calle" value="<?php echo($CALLE[$i]); ?>"/></center></td>
                                  <td><center><input type="text" class="num" name="numext" value="<?php echo($NUMERO_EXTERIOR[$i]); ?>"/></center></td>
                                   <td><center><input type="text" class="num" name="numint" value="<?php echo($NUMERO_INTERIOR[$i]); ?>"/></center></td>
                                    <td><center><input type="text" name="colonia" value="<?php echo($COLONIA[$i]); ?>"/></center></td>
                        </tr>
                        <tr>
                            <th style="color:black;"><center>Casa</center></th>
                        <th style="color:black;"><center>Celular</center></th>
                        <th style="color:black;" ><center>Email</center></th>
                        <th style="color:black;" ><center>Codigo Postal</center></th>
                        <th style="color:black;"><center>Es Afiliado</center></th>
                        </tr>
                        <tr>
                                     <td><center><input type="text" class="phone" name="casa" value="<?php echo($CASA[$i]); ?>"/></center></td>
                                      <td><center><input type="text" class="phone" name="celular" value="<?php echo($CELULAR[$i]); ?>"/></center></td>
                                       <td ><center><input type="text" class="mail" name="email" value="<?php echo($email[$i]); ?>"/></center></td>
                                        <td ><center><input type="text" class="CP" name="cp" value="<?php echo($cp[$i]); ?>"/></center></td>
                                        <td colspan="2"><center>
                                            <?php
                                            if($db->esAfiliado($CLAVE_ELECTORAL[$i])){
                                                $fecha=substr($db->dameFecha($CLAVE_ELECTORAL[$i]),0,11);
                                                $fecha=str_replace("Jan","Ene",$fecha);
                                                $fecha=str_replace("Jan","Ene",$fecha);
                                                $fecha=str_replace("Apr","Abr",$fecha);
                                                $fecha=str_replace("Aug","Ago",$fecha);
                                                $fecha=str_replace("Dec","Dic",$fecha);
                                                        echo("desde: ".$fecha);
                                            }else{
                                                echo("No");
                                            }
                                            ?>
                                        </center></td>
                        </tr>
                       
                        <tr>
                            <td colspan="5"><center><input type="hidden" name="idmun" value="<?php echo($IdMunicipio[$i]); ?>"/><input type="submit" class="button" value="Seleccionar"/></center></td>
                            </form>
                        
                        </tr>
                        <?php
                        if($db->tieneFoto($CLAVE_ELECTORAL[$i])){
                            ?>
                            <tr>
                            <td colspan="5"><center><a href="get_cred.php?ce=<?php echo($CLAVE_ELECTORAL[$i]); ?>" target="_BLANK"><input type="button" class="button" value="Imprimir Credencial"/></a></center></td>
                            
                        
                        </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td colspan="5" style="background:black;"></td>
                        </tr>
                        <?php
                        
                             }
                    }
                    
                    ?>
                    <tr>
                        <th colspan="5" style="color:black;">No Esta En Lista Nominal?</th>
                    </tr>
                    <!------------------no en lista--------->
                    <form action="altas.php" method="post">
                         <tr>
                            <th rowspan="4"><img src="images/noregistrado.jpg" width="150" height="150" alt="no image"/></th>
                        <th style="color:black;">Nombre</th>
                        <td colspan="4"><center>
                        Paterno&nbsp;<input type="text" name="ap" />
                        &nbsp;Materno:&nbsp;   <input type="text" name="am" />
                        &nbsp;Nombre:&nbsp;      <input type="text" name="n"/></center>
                        </td>
                         </tr>
                         <tr>
                        
                        <th style="color:black;">Clave Electoral</th>
                        <td colspan="4" ><center><input type="text" name="ce" /></td>
                        
                        </center></td>
                         </center>
                         </tr>
                         <tr>
                            <th style="color:black;">Cargo</th><td colspan="3"><select name="idcargo">
                                <?php
                                for($j=0;$j<count($idcargos);$j++){
                                    ?><option value="<?php echo($idcargos[$j]); ?>"
                                   
                                    ><?php echo($desccargos[$j]); ?></option><?php
                                }
                                ?>
                            </select></td>
                         </tr>
                        <tr>
                            
                            <th style="color:black;" colspan="4" ><center>Datos Personales</center></th>
                               
                        </tr>
                        <tr>
                            <th style="color:black;"><center>Municipio</center></th>
                        <th style="color:black;"><center>Calle</center></th>
                        <th style="color:black;"><center>Num Exterior</center></th>
                        <th style="color:black;"><center>Num Interior</center></th>
                        <th style="color:black;"><center>Colonia</center></th>
                        </tr>
                        <tr>
                            <?php
                            $mun=$db->getMunicipios();
                            $idmun=explode(",",$mun[0]);
                            $nmun=explode(",",$mun[1]);
                            ?>
                                <td><center><select name="idmun">
                                    <?php
                                    if($idmun[0]!=""){
                                        for($i=0;$i<count($idmun);$i++){
                                           ?><option value="<?php echo($idmun[$i]); ?>"><?php echo($nmun[$i]); ?></option><?php 
                                        }
                                    }
                                    ?>
                                </select></center></td>
                                 <td><center><input type="text" name="calle" /></center></td>
                                  <td><center><input type="text" class="num" name="numext" /></center></td>
                                   <td><center><input type="text" class="num" name="numint" /></center></td>
                                    <td><center><input type="text" name="colonia" /></center></td>
                        </tr>
                        <tr>
                            <th style="color:black;"><center>Casa</center></th>
                        <th style="color:black;"><center>Celular</center></th>
                        <th style="color:black;" ><center>Email</center></th>
                        <th style="color:black;" ><center>Codigo Postal</center></th>
                        <th style="color:black;"><center>Es Afiliado</center></th>
                        </tr>
                        <tr>
                                     <td><center><input type="text" class="phone" name="casa" /></center></td>
                                      <td><center><input type="text" class="phone" name="celular" /></center></td>
                                       <td ><center><input type="text" class="mail" name="email" /></center></td>
                                       <td ><center><input type="text" class="cp" name="cp" /></center></td>
                                        <td colspan="2"><center>
                                            No
                                        </center></td>
                        </tr>
                       
                        <tr>
                            <td colspan="5"><center><input type="submit" class="button" value="Seleccionar"/></center></td>
                            </form>
                        
                        </tr>
                    <!-----------------no en lista----------->
                </table> <?php
                    }
                
                

            ?>
        </center>
        <?php
                }else if(!ISSET($_POST["guardar"])){
                    
                    ?>
                    <center>
                        <!-- First, include the JPEGCam JavaScript Library -->
	<script type="text/javascript" src="js/webcam.js"></script>
	
	<!-- Configure a few settings -->
	<script language="JavaScript">
		webcam.set_api_url( 'test.php' );
		webcam.set_quality( 90 ); // JPEG quality (1 - 100)
		webcam.set_shutter_sound( true ); // play shutter click sound
	</script>
	
	<!-- Next, write the movie to the page at 320x240 -->
	<script language="JavaScript">
		document.write( webcam.get_html(320, 240) );
	</script>
	
	<!-- Some buttons for controlling things -->
	<br/><form>
		<input type=button value="Configurar..." onClick="webcam.configure()">
		&nbsp;&nbsp;&nbsp;
		<input type=button value="Tomar Foto" onClick="webcam.snap()">
	</form>
	
	<!-- Code to handle the server response (see test.php) -->
	<script language="JavaScript">
		webcam.set_hook( 'onComplete', 'my_completion_handler' );
		
		function my_completion_handler(msg) {
			// extract URL out of PHP output
			if (msg.match(/(http\:\/\/\S+)/)) {
				var image_url = RegExp.$1;
				// show JPEG image in page
				document.getElementById('upload_results').innerHTML = 
					
					'<img width="150" height="150" src="'+image_url+'">';
			}
			else alert("PHP Error: " + msg);
		}
	</script>
	
	<!--</td><td width=50>&nbsp;</td><td valign=top>
		<div id="upload_results"></div>
	</td></tr>-->
        <?php
        $esafiliado=$db->esAfiliado($_COOKIE["ceAfiliado"]);
        ?>
        <form action="altas.php" ENCTYPE="multipart/form-data" method="post">
            <table border="1">
                <tr>
                    <td rowspan="3" id="upload_results" >
                        
                        <img width="150" height="150" src="<?php
                        if(ISSET($_COOKIE["idfoto"])){
                            echo("snapshots/".$_COOKIE["ceAfiliado"] .$_COOKIE["idfoto"]. '.jpg');
                        }
                        ?>"/>
                    </td>
                    <?php
                    $sexo="";
                    if($esafiliado)
                        $sexo=$db->getSexo($_COOKIE["ceAfiliado"]);
                    else
                        $sexo=$db->getSexoP($_COOKIE["ceAfiliado"]);
                    ?>
                    <th style="color:black;">Genero</th><td><center>
                            <select name="sexo" >
                                <option value="H" <?php if($sexo=="H") {echo(" selected ");} ?>>H</option>
                                <option value="M" <?php if($sexo=="M") {echo(" selected ");} ?>>M</option>
                            </select>
                </tr>
                <tr>
                    <th style="color:black;">Seccion</th>
                    <input type="hidden" name="guardar" value="1"/>
                    <td><select name="idseccion">
                        <?php
                        if($esafiliado)
                        $mysec=$db->getIdSeccionb($_COOKIE["ceAfiliado"]);
                        else
                         $mysec=$db->getIdSeccion($_COOKIE["ceAfiliado"]);
                        $secciones=$db->getSecciones();
                        $idsec=explode(",",$secciones[0]);
                        $nsecc=explode(",",$secciones[1]);
                        if($idsec[0]!=""){
                            for($i=0;$i<count($idsec);$i++){
                                ?><option value="<?php echo($idsec[$i]);?>" <?php if($mysec==$idsec[$i]){echo(" selected ");} ?>><?php echo($nsecc[$i]);  ?></option><?php
                            }
                        }
                       // echo($mysec);
                        ?>
                    </select></td>
                    
                </tr>
                <tr>
                    <th style="color:black;">Sector Organizacion</th>
                    <td><select name="sectororg">
                        <?php
                        $mysector=$db->getSectorOrgb($_COOKIE["ceAfiliado"]);
                        $sect= $db->getSectorOrg();
                        $idsec=explode(",",$sect[0]);
                        $nsec=explode(",",$sect[1]);
                        for($i=0;$i<count($idsec);$i++){
                            ?><option value="<?php echo($idsec[$i]); ?>" <?php if($mysector==$idsec[$i]){echo(" selected ");} ?> ><?php echo($nsec[$i]); ?></option><?php
                        }
                        ?>
                    </select></td>
                </tr>
                <tr>
                    <th style="color:black;"> <input type="hidden" name="foto" value="<?php
                        if(ISSET($_COOKIE["idfoto"])){
                            echo("snapshots/".$_COOKIE["ceAfiliado"] .$_COOKIE["idfoto"]. '.jpg');
                        }
                        ?>"/>
                      <center>  Folio</center>
                    </th>
                    <?php
                    $initfolio=$db->getIniFolio($_COOKIE["IDAFI"]);
                    $nfolio=$db->dameFolio($_COOKIE["ceAfiliado"]);
                    ?>
                    <td
                    <?php
                    if($nfolio!="")
                    {
                        ?>colspan="2"
                        <?php
                    }
                    ?>
                        ><center><?php
                    if($nfolio!="")
                    echo($nfolio);
                    else{
                    echo($initfolio);
                    ?><input type="hidden" name="initfolio" value=""/><input type="hidden" name="folio" value="<?php echo($nfolio); ?>"/><?php
                    }
                    ?>
                    
                        </center></td>
                         <?php
                        
                        if($nfolio==""){
                            ?>
                            
                    <td>
                       
                       
                         
                        <script type="text/javascript">
                                function justNumbers(e)
                                        {
                                        var keynum = window.event ? window.event.keyCode : e.which;
                                        if ((keynum == 8) || (keynum == 46))
                                        return true;
                                         
                                        return /\d/.test(String.fromCharCode(keynum));
                                        }


                        </script>
                        
                        <input type="hidden" name="initfolio" value="<?php echo($initfolio); ?>"/><input type="text" name="folio" onkeypress="return justNumbers(event);" />
                    <?php
                        }
                        ?>
                    </td>
                </tr>
                
                <tr><td colspan="3"><center><input type="submit" value="Guardar" class="button" /></center></td></tr>
            </table>
        </form>
                        <form action="altas.php" method="post" >
                            <input type="submit" name="cancel" value="Cancelar" class="button"/>
                        </form>
                    </center>
                    <?php
                }
    
    ?>
</body>
</html>
