<?php
class dbManager{
     #code
        public function testConnection(){
            require("settings.php");
            $msquery ="SELECT * FROM CRED_Perfiles;";
            $msresults=mssql_query($msquery);
            while($row=mssql_fetch_array($msresults)){
                echo($row["Perfil"]."<br/>");
            }
        }
        public function getMunicipios(){
	    require("settings.php");
            $uss= array("","");
	    $msquery="SELECT IdMunicipio,NOMBRE_MUNICIPIO FROM DATOS_MUNICIPIOS;";
            $msresults=mssql_query($msquery);
            while($row=mssql_fetch_array($msresults)){
                //echo($row["UserId"]."<br/>");
                $uss[0]=$uss[0].",".$row["IdMunicipio"];
                //echo($row["usr"]);
                $uss[1]=$uss[1].",".$row["NOMBRE_MUNICIPIO"];
            }
            $uss[0]=substr($uss[0], 1, strlen($uss[0]));
	    $uss[1]=substr($uss[1], 1, strlen($uss[1]));
            return $uss;
	}
	public function getUsuarios(){
            require("settings.php");
            $uss= array("","","","");
            $msquery="SELECT IdUsuario as usr,CRED_Usuarios.Usuario AS UserName,CRED_Usuarios.Rol, CRED_Usuarios.Nrol FROM CRED_Usuarios;";
            $msresults=mssql_query($msquery);
            while($row=mssql_fetch_array($msresults)){
                //echo($row["UserId"]."<br/>");
                $uss[0]=$uss[0].",".$row["usr"];
                //echo($row["usr"]);
                $uss[1]=$uss[1].",".$row["UserName"];
                $uss[2]=$uss[2].",".$row["Rol"];
                $uss[3]=$uss[3].",".$row["Nrol"];
            }
            $uss[0]=substr($uss[0], 1, strlen($uss[0]));
	    $uss[1]=substr($uss[1], 1, strlen($uss[1]));
	    $uss[2]=substr($uss[2], 1, strlen($uss[2]));
            $uss[3]=substr($uss[3], 1, strlen($uss[3]));
            return $uss;
        }
        public function getRoles(){
             require("settings.php");
            $uss= array("","");
            //$uss[0]="0,99";
            //$uss[1]="Ninguno,Administrador";
            //$msquery="SELECT IdMunicipio, NOMBRE_MUNICIPIO FROM DATOS_MUNICIPIOS";
             $msquery="SELECT Rol, Nrol FROM CRED_Roles;";
            $msresults=mssql_query($msquery);
            while($row=mssql_fetch_array($msresults)){
                //echo($row["UserId"]."<br/>");
                //$uss[0]=$uss[0].",".$row["IdMunicipio"];
                $uss[0]=$uss[0].",".$row["Rol"];
                //echo($row["usr"]);
                //$uss[1]=$uss[1].",".$row["NOMBRE_MUNICIPIO"];
                 $uss[1]=$uss[1].",".$row["Nrol"];
            }
            $uss[0]=substr($uss[0], 1, strlen($uss[0]));
	    $uss[1]=substr($uss[1], 1, strlen($uss[1]));
            
            return $uss;
            
        }
        public function asignaRol($iduser,$idrol,$pass){
            require("settings.php");
            
            $existe=false;
            $count="0";
             $msquery="SELECT COUNT(*) as count FROM CRED_Usuarios WHERE IdUsuario=".$iduser." ;";
            $msresults=mssql_query($msquery);
            while($row=mssql_fetch_array($msresults)){
                $count=$row["count"];
            }
            if(intval($count)>0){
                $existe=true;
            }
            //echo($msquery);
            if($existe==true){
                
                if($pass!=""){
                 $msquery="UPDATE CRED_Usuarios SET Password2='".md5($pass)."', Rol=".$idrol." WHERE IdUsuario=".$iduser." ;";
                }else{
                 $msquery="UPDATE CRED_Usuarios SET  Rol=".$idrol." WHERE IdUsuario=".$iduser." ;";
                }
                
            }
           //echo($msquery);
            $msresults=mssql_query($msquery);
        }
        public function valida($palabra,$numero){
            $resp=true;
			
			
			if($numero==true){
				if(!is_numeric($palabra)){
					if(!is_float($palabra)){
					$resp=false;	
					//echo($palabra); 			
					}
				}			
			
			}else{
					$palabra = addslashes($palabra);
					/*if (ereg("[^A-Za-z0-9]+",trim($palabra," "))) {
					$resp=false;
						} */
			}
			
			
			return $resp;
            
        }
        public function autenticar($us,$pw){
             require("settings.php");
             $msquery="SELECT CRED_Usuarios.Usuario AS UserName, CRED_Usuarios.IdUsuario AS IdUser,CRED_Usuarios.Rol FROM CRED_Usuarios WHERE CRED_Usuarios.Usuario='".$us."' AND CRED_Usuarios.Password2='".MD5($pw)."' ;";
            $msresults=mssql_query($msquery);
            $usname="";
            $iduser="";
            $rol="";
            while($row=mssql_fetch_array($msresults)){
                $usname=$row["UserName"];
                 $iduser=$row["IdUser"];
                  $rol=$row["Rol"];
            }
            return array($usname,$iduser,$rol);
        }
	public function getIniFolio($user){
	    require("settings.php");
            $initfolio="";
             $msquery="SELECT NUM_MUNICIPIO,U.Rol FROM CRED_Usuarios U LEFT JOIN DATOS_MUNICIPIOS M ON M.IdMunicipio=U.Rol WHERE U.IdUsuario=".$user;
            $msresults=mssql_query($msquery);
            while($row=mssql_fetch_array($msresults)){
		if($row["Rol"]!="99")
               $initfolio="080".$row["NUM_MUNICIPIO"];
	       else
	       $initfolio="08019";
               
            }
	    
            return $initfolio;
	}
	public function borraCokkiesAfiliado(){
	    if(ISSET($_COOKIE["ceAfiliado"])&&ISSET($_COOKIE["idfoto"])){
	    if(file_exists("snapshots/".$_COOKIE["ceAfiliado"].".jpg"))
		unlink("snapshots/".$_COOKIE["ceAfiliado"].".jpg");
        for($i=0;$i<=intval($_COOKIE["idfoto"]);$i++){
	    if(file_exists("snapshots/".$_COOKIE["ceAfiliado"].$i.".jpg"))
		unlink("snapshots/".$_COOKIE["ceAfiliado"].$i.".jpg");
        }
	    }  
	    
        setcookie("nomAfiliado","");
            setcookie("paternoAfiliado","");
            setcookie("maternoAfiliado","");
            setcookie("calleAfiliado","");
            setcookie("numextAfiliado","");
            setcookie("numintAfiliado","");
            setcookie("coloniaAfiliado","");
            setcookie("ceAfiliado","");
            setcookie("idcargoAfiliado","");
            setcookie("myimage","");
	      setcookie("cpAfiliado","");
            setcookie("idfoto","");
	}public function formatoFolio($prefijo,$subfijo){
	    $folio=$prefijo;
	    $num =strlen($subfijo);
	    for($i=0;$i<(6-$num);$i++){
		$folio=$folio."0";
	    }
	    $folio=$folio.$subfijo;
	    return $folio;
	}
	public function getSexo($ce){
	    require("settings.php");
	    $sexo="";
	    $sql="SELECT Sexo FROM CRED_Afiliados WHERE ClaveElectoral='$ce'";
	    $msresults=mssql_query($sql);
	    while($row=mssql_fetch_array($msresults)){
               $sexo=$row["Sexo"];
	    }
	    return $sexo;
	}
	public function getSexoP($ce){
	    require("settings.php");
	    $sexo="";
	    $sql="SELECT SEXO FROM PADRON_ELECTORAL WHERE CLAVE_ELECTORAL='$ce'";
	    $msresults=mssql_query($sql);
	    while($row=mssql_fetch_array($msresults)){
               $sexo=$row["SEXO"];
	    }
	    return $sexo;
	}
	public function updateAfiliado($paterno,$materno,$nombre,$calle,$numext,$numint,$colonia,$idcargo,$idseccion,$id_sector_org,$cp,$folio,$idus,$ce,$sexo){
	    require("settings.php");
	    
	    $sql="UPDATE CRED_Afiliados SET Paterno='$paterno',Materno='$materno',Nombre='$nombre',Calle='$calle',NumExt='$numext',NumInt='$numint',Colonia='$colonia',IdCargo=$idcargo,IdSeccion=$idseccion,Id_Sector_Org=$id_sector_org,Renovacion=1,CodigoPostal='$cp',Telefono=(SELECT TOP 1 CASA FROM PADRON_DATOS_PERSONALES WHERE CLAVE_ELECTORAL='$ce'),Email=(SELECT TOP 1 email FROM PADRON_DATOS_PERSONALES WHERE CLAVE_ELECTORAL='$ce'),Sexo='$sexo',Edad=dbo.dameEdad('$ce'),Folio='$folio',idUsuarioModifica=$idus,FechaModificado=GETDATE(),Seccion=(SELECT TOP 1 Seccion FROM DATOS_Secciones WHERE IdSeccion=$idseccion ) WHERE ClaveElectoral='$ce'";
	   // echo $sql;die();
	   // $msresults=mssql_init($sql);
	   $msresults=mssql_query($sql);
	    //mssql_bind($msresults, '@foto',  $foto,  'SQLIMAGE');
	   // mssql_execute($msresults);

	    // Liberar los recursos
	   // mssql_free_statement($msresults);
	}
	public function validaClaveElectoral($ce){
	    
	    if(strlen($ce)<16)
	   return false;
	    
	    if(!is_numeric(substr($ce,6,2)))
		return false;
		
	    if(!is_numeric(substr($ce,8,2)))
		return false;
		
	    if(!is_numeric(substr($ce,10,2)))
		return false;
	    
	    $mes=intval(substr($ce,8,2));
	    if($mes<=0 || $mes>12)
	     return false;
	    $dia=intval(substr($ce,10,2));
	    if($dia<=0||$dia>31)
		return false;
	    return true;
	}
	public function updateFoto($ce,$rutafoto){
	    require("settings.php");
	     $rutas=explode("/",$rutafoto);
	      //ruta para CENTOS
	   $rutafisica="/var/www/html/AFILIACION/snapshots/".$rutas[count($rutas)-1];
	       //Ruta para Windows
	      // $rutafisica="C:/inetpub/wwwroot/php/AFILIACION/snapshots/".$rutas[count($rutas)-1];
              $gestor = fopen($rutafisica, "rb");
	     
	       
		 $size=filesize($rutafisica);
                //$size=readfile($rutafoto);
                 //echo($size."---------");
                    $foto=fread($gestor,$size);
                    //$foto=addslashes($foto);
                    fclose($gestor);
		    
	    $arrData = unpack("H*hex", $foto); $foto = "0x".$arrData['hex'];
	     $sql="UPDATE CRED_Afiliados SET Foto=CONVERT(image,$foto) WHERE ClaveElectoral='$ce'";
	     $msresults=mssql_query($sql);
	    /*require_once("pdo.php");
	    $dbo = new PDO ("dblib:host=$hostname:$port;dbname=$dbname","$username","$pw");
	    $stmt=$dbo->prepare("UPDATE CRED_Afiliados SET Foto=? WHERE ClaveElectoral=?");
	    $fp=fopen($rutafoto,'rb');
	    $stmt->bindParam(1,$fp,PDO::PARAM_LOB);
	    $stmt->bindParam(2,$ce);
	    $dbo->beginTransaction();
	    $dbo->execute();
	    $dbo->commit();*/
	}
	public function AgregaAfiliado($Paterno,$Materno,$Nombre,$Calle,$NumExt,$NumInt,$Colonia,$ClaveElectoral,$IdSeccion,$CodigoPostal,$IdUsuarioAlta,$Id_Sector_Org,$folio,$idcargo,$sexo){
	    require("settings.php");
	    $sql="INSERT INTO CRED_Afiliados(Paterno,Materno,Nombre,Calle,NumExt,NumInt,Colonia,ClaveElectoral,EnPadron,IdSeccion,CodigoPostal,Telefono,Email,Sexo,Folio,IdUsuarioAlta,FechaAlta,Seccion,Id_Sector_Org,Edad,IdCargo,EnLista) VALUES ('$Paterno','$Materno','$Nombre','$Calle','$NumExt','$NumInt','$Colonia','$ClaveElectoral',(SELECT COUNT(*) FROM PADRON_ELECTORAL WHERE CLAVE_ELECTORAL='$ClaveElectoral'),$IdSeccion,'$CodigoPostal',(SELECT TOP 1 CASA FROM PADRON_DATOS_PERSONALES WHERE CLAVE_ELECTORAL='$ClaveElectoral'),(SELECT TOP 1 email FROM PADRON_DATOS_PERSONALES WHERE CLAVE_ELECTORAL='$ClaveElectoral'),'$sexo', '$folio',$IdUsuarioAlta,GETDATE(),(SELECT TOP 1 Seccion FROM DATOS_Secciones WHERE IdSeccion=$IdSeccion ),$Id_Sector_Org,dbo.dameEdad('$ClaveElectoral'),$idcargo,(SELECT COUNT(*) FROM PADRON_ELECTORAL WHERE CLAVE_ELECTORAL='$ClaveElectoral'))";
	    $msresults=mssql_query($sql);
	}
	public function validaFolio($folio){
	    require("settings.php");
	    //$result=array(true,"");
	    $sql="SELECT Estatus FROM CRED_Folios WHERE NumeroFolio='$folio'";
	     $msresults=mssql_query($sql);
	     $estatus="";
	     while($row=mssql_fetch_array($msresults)){
               $estatus=$row["Estatus"];
            }
	    $resp=false;
	    if(trim($estatus," ")=="AC"){
		$resp=true;
	    }
	    return $resp;
	}
	public function dameFolio($ce){
	    require("settings.php");
	    //$result=array(true,"");
	    $sql="SELECT NumeroFolio AS Estatus FROM CRED_Folios WHERE IdAfiliado=(SELECT TOP 1 IdAfiliado FROM CRED_Afiliados WHERE ClaveElectoral='$ce')";
	     $msresults=mssql_query($sql);
	     $estatus="";
	     while($row=mssql_fetch_array($msresults)){
               $estatus=$row["Estatus"];
            }
	    
	    return $estatus;
	}
	public function dameFecha($ce){
	    require("settings.php");
	    //$result=array(true,"");
	    $sql="SELECT FechaAlta FROM CRED_Afiliados WHERE ClaveElectoral='$ce'";
	     $msresults=mssql_query($sql);
	     $estatus="";
	     while($row=mssql_fetch_array($msresults)){
               $estatus=$row["FechaAlta"];
            }
	    
	    return $estatus;
	}
	public function actualizaFolio($ce,$folio){
	    require("settings.php");
	    $sql="UPDATE CRED_FOLIOS SET Estatus='UT',IdAfiliado=(SELECT TOP 1 IdAfiliado FROM CRED_Afiliados WHERE ClaveElectoral='$ce') WHERE NumeroFolio='$folio'";
	     $msresults=mssql_query($sql);
	}
        public function configuracion($page){
        //echo("<br/>".$page);
            if($page=="usuarios.php"){
                if($_COOKIE["ROLAFI"]!=md5('99')){
		    setcookie("page", "");	
  		   header('Location: login.php');						
						
                }
             }
             if($page=="altas.php"){
                if(ISSET($_COOKIE["ROLAFI"])){
                    //echo($_COOKIE["ROLAFI"]);
                    $val=false;
                    if($_COOKIE["ROLAFI"]!=md5("99")){
                        for($i=1;$i<68;$i++){
                            if($_COOKIE["ROLAFI"]==md5($i)){
                                $val=true;
                                $i=70;
                            }
                        }
                        if($val==false){
                           // echo($_COOKIE["ROLAFI"]);
                            header('Location: login.php');
                            
                        }
                    }
                }else{
                    header('Location: login.php');	
                }
             }
             if($page=="cambios.php"||$page=="bajas.php"){
                if(ISSET($_COOKIE["ROLAFI"])){
                    //echo($_COOKIE["ROLCPE"]);
                    $val=false;
                    if($_COOKIE["ROLAFI"]!=md5("99")){
                        for($i=1;$i<68;$i++){
                            if($_COOKIE["ROLAFI"]==md5($i)){
                                $val=true;
                                $i=70;
                            }
                        }
                        if($val==false){
                           // echo($_COOKIE["ROLAFI"]);
                            header('Location: login.php');
                            
                        }
                    }
                }else{
                    header('Location: login.php');	
                }
             }
        }
        public function getSecciones(){
	    require("settings.php");
            $secciones=array("","");
            $msquery="SELECT IdSeccion,Seccion FROM DATOS_Secciones ";
            $msresults=mssql_query($msquery);
            while($row=mssql_fetch_array($msresults)){
               $secciones[0]=$secciones[0].",".$row["IdSeccion"];
               $secciones[1]=$secciones[1].",".$row["Seccion"];
            }
            $secciones[0]=substr($secciones[0], 1, strlen($secciones[0]));
	    $secciones[1]=substr($secciones[1], 1, strlen($secciones[1]));
            return $secciones;
	}
	public function getSectorOrg(){
	    require("settings.php");
            $secciones=array("","");
            $msquery="SELECT IdClave,Descripcion FROM CRED_Sector_Organizacion ";
            $msresults=mssql_query($msquery);
            while($row=mssql_fetch_array($msresults)){
               $secciones[0]=$secciones[0].",".$row["IdClave"];
               $secciones[1]=$secciones[1].",".$row["Descripcion"];
            }
            $secciones[0]=substr($secciones[0], 1, strlen($secciones[0]));
	    $secciones[1]=substr($secciones[1], 1, strlen($secciones[1]));
            return $secciones;
	}
        public function getMunicipio($id){
            require("settings.php");
            $nmun="";
            $msquery="SELECT NOMBRE_MUNICIPIO FROM DATOS_MUNICIPIOS WHERE IdMunicipio=".$id;
            $msresults=mssql_query($msquery);
            while($row=mssql_fetch_array($msresults)){
               
                $mun=$row["NOMBRE_MUNICIPIO"];
            }
            
            return $mun;
        }
        public function getCargos(){
            require("settings.php");
            
            $msquery="SELECT * FROM CRED_Cargos ";
            
            $uss= array("","");
            
            $msresults=mssql_query($msquery);
            while($row=mssql_fetch_array($msresults)){
                $uss[0]=$uss[0].",".$row[0];
                $uss[1]=$uss[1].",".$row[3];
            }
            $uss[0]=substr($uss[0], 1, strlen($uss[0]));
	    $uss[1]=substr($uss[1], 1, strlen($uss[1]));
            
            return $uss;
        }
	public function esAfiliado($ce){
            require("settings.php");
            
            $msquery="SELECT COUNT(*) FROM CRED_Afiliados WHERE ClaveElectoral='$ce' ";
            
            $count=0;
            
            $msresults=mssql_query($msquery);
            while($row=mssql_fetch_array($msresults)){
                $count=$row[0];
                
            }
            $resp=false;
	    if(intval($count)>0){
		$resp=true;
	    }
            
            return $resp;
        }
	public function tieneFoto($ce){
            require("settings.php");
            
            $msquery="SELECT foto FROM CRED_Afiliados WHERE ClaveElectoral='$ce' ";
            
            $foto="";
            
            $msresults=mssql_query($msquery);
            while($row=mssql_fetch_array($msresults)){
                $foto=$row[0];
                
            }
            $resp=false;
	    
	    if($foto!=""){
		$resp=true;
	    }
            
            return $resp;
        }
        
	    function getImage($ce){
		require("settings.php");
		
		 $msquery = "SELECT foto FROM CRED_Afiliados WHERE (ClaveElectoral='$ce')" ;
		$msresults=mssql_query($msquery);
            while($row=mssql_fetch_array($msresults)){
                header("Content-type: image/jpeg"); 
             return $row['foto']; 
		}
		//return $foto;
	    }
	    

    function newimage($src) {
        $im = false;
        switch(true) {
            case eregi('http://', $src):
                $im = imagecreatefromstring( getUrlData($src) );
                imagealphablending($im, true);
                imagesavealpha($im, true);
            break;
            case eregi('\.jpg', $src):
                $im = imagecreatefromjpeg($src);    
            break;
            case eregi('\.gif', $src):
                $imp = imagecreatefromgif($src);
     
                $x = imagesx($imp);
                $y = imagesy($imp);
                $im = imagecreatetruecolor($x, $y);
                imagefilledrectangle( $im, 0, 0, $x, $y, imagecolorallocate($im, 255, 255, 255) );
                imagecopy($im, $imp, 0, 0, 0, 0, $x, $y);
            break;
            case eregi('\.png', $src):
                $im = imagecreatefrompng($src);    
     
                imagealphablending($im, true);
                imagesavealpha($im, true);
            break;
        }
        return $im;
    }
    function getUrlData($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $get = curl_exec($ch);
        curl_close($ch);
        return $get;
    }


	    function puntos_cm ($medida, $resolucion=72)
	    {
	       //// 2.54 cm / pulgada
	       return ($medida/(2.54))*$resolucion;
	    }
		    
        public function getRolDec($uss){
            require("settings.php");
            $msquery="SELECT Rol FROM CRED_Usuarios WHERE IdUsuario=".$uss."";
           // echo($msquery);
            $msresults=mssql_query($msquery);
            $rol="";
            while($row=mssql_fetch_array($msresults)){
                $rol=$row["Rol"];
            }
           //echo($rol);
            return $rol;
        }
        
        
        public function getCredencial($ce){
	    require("settings.php");
	    $sql="SELECT A.Nombre+' ' +A.Paterno+' ' + A.Materno as Nomb, A.Calle+' N° '+ A.NumExt AS Domicilio, A.Colonia, A.Sexo, A.ClaveElectoral, DF.Num as DistritoFederal, DL.Num as DistritoLocal, S.Seccion, M.NOMBRE_MUNICIPIO, SO.Descripcion AS SectOrg,A.FechaAlta, CA.Descripcion FROM ";
	    $sql=$sql." CRED_Afiliados A LEFT JOIN DATOS_Secciones S ON S.Seccion=A.Seccion LEFT JOIN DATOS_MUNICIPIOS M ON M.IdMunicipio=S.IdMunicipio LEFT JOIN DATOS_DistritosFederales DF ON DF.IdDistritoFederal=S.IdDistritoFederal LEFT JOIN DATOS_DistritosLocales DL ";
	    $sql=$sql." ON DL.IdDistritoLocal=S.IdDistritoLocal LEFT JOIN CRED_Sector_Organizacion SO ON SO.IdClave=A.Id_Sector_Org LEFT JOIN CRED_Cargos CA ON CA.IdCargo=A.IdCargo WHERE A.ClaveElectoral='".$ce."'";
	    $uss= array("","","","","","","","","","","","");//,"","","");
            
            $msresults=mssql_query($sql);
            while($row=mssql_fetch_array($msresults)){
                $uss[0]=$row["Nomb"];
                $uss[1]=$row["Domicilio"];
                $uss[2]=$row["Colonia"];
                $uss[3]=$row["Sexo"];
                $uss[4]=$row["ClaveElectoral"];
                $uss[5]=$row["DistritoFederal"];
                $uss[6]=$row["DistritoLocal"];
                $uss[7]=$row["Seccion"];
                $uss[8]=$row["NOMBRE_MUNICIPIO"];
		$uss[9]=$row["SectOrg"];
		$uss[10]=$row["FechaAlta"];
		$uss[11]=$row["Descripcion"];
            }
            return $uss;
	}
        public function getSectorOrgb($ce){
	    require("settings.php");
	    $sql="SELECT Id_Sector_Org FROM CRED_Afiliados  WHERE ClaveElectoral='$ce'";
	    $uss= "";
            
            $msresults=mssql_query($sql);
            while($row=mssql_fetch_array($msresults)){
                $uss=$row["Id_Sector_Org"];
                
            }
            return $uss;
	}
	public function getIdSeccionb($ce){
	    require("settings.php");
	    $sql="SELECT IdSeccion  FROM CRED_Afiliados WHERE ClaveElectoral='$ce'";
	    $uss= "";
            
            $msresults=mssql_query($sql);
            while($row=mssql_fetch_array($msresults)){
                $uss=$row["IdSeccion"];
                
            }
            return $uss;
	}
        public function getFromPadron($paterno,$materno,$nombre){
            $paterno=strtoupper($paterno);
            $materno=strtoupper($materno);
            $nombre=strtoupper($nombre);
            require("settings.php");
            $msquery="SELECT TOP 100 APELLIDO_PATERNO,APELLIDO_MATERNO,PADRON_ELECTORAL.NOMBRE,PADRON_ELECTORAL.CLAVE_ELECTORAL ";
            $msquery=$msquery." ,DATOS_MUNICIPIOS.NOMBRE_MUNICIPIO,PADRON_ELECTORAL.CALLE,PADRON_ELECTORAL.NUM_EXTERIOR, ";
            $msquery=$msquery." PADRON_ELECTORAL.NUM_INTERIOR ,PADRON_ELECTORAL.COLONIA,PADRON_DATOS_PERSONALES.CASA, ";
            $msquery=$msquery." PADRON_DATOS_PERSONALES.CELULAR,PADRON_DATOS_PERSONALES.email, ";
            $msquery=$msquery." DATOS_MUNICIPIOS.IdMunicipio, CRED_Afiliados.foto, CRED_Afiliados.IdCargo,CODIGO_POSTAL FROM PADRON_ELECTORAL LEFT JOIN DATOS_MUNICIPIOS ";
            $msquery=$msquery." ON DATOS_MUNICIPIOS.NUM_MUNICIPIO=CAST(PADRON_ELECTORAL.MUNICIPIO AS Int) LEFT JOIN PADRON_DATOS_PERSONALES ";
            $msquery=$msquery." ON PADRON_ELECTORAL.CLAVE_ELECTORAL=PADRON_DATOS_PERSONALES.CLAVE_ELECTORAL LEFT JOIN CRED_Afiliados ON CRED_Afiliados.ClaveElectoral=PADRON_ELECTORAL.CLAVE_ELECTORAL ";
            $msquery=$msquery." WHERE APELLIDO_PATERNO LIKE '".$paterno."%' AND APELLIDO_MATERNO LIKE '".$materno."%' AND PADRON_ELECTORAL.NOMBRE LIKE '%".$nombre."%' ";
            $uss= array("","","","","","","","","","","","","","","");//,"","","");
            
            $msresults=mssql_query($msquery);
            while($row=mssql_fetch_array($msresults)){
                $uss[0]=$uss[0].",".$row["APELLIDO_PATERNO"];
                $uss[1]=$uss[1].",".$row["APELLIDO_MATERNO"];
                $uss[2]=$uss[2].",".$row["NOMBRE"];
                $uss[3]=$uss[3].",".$row["CLAVE_ELECTORAL"];
                $uss[4]=$uss[4].",".$row["NOMBRE_MUNICIPIO"];
                $uss[5]=$uss[5].",".$row["CALLE"];
                $uss[6]=$uss[6].",".$row["NUM_EXTERIOR"];
                $uss[7]=$uss[7].",".$row["NUM_INTERIOR"];
                $uss[8]=$uss[8].",".$row["COLONIA"];
                $uss[9]=$uss[9].",".$row["CASA"];
                $uss[10]=$uss[10].",".$row["CELULAR"];
                $uss[11]=$uss[11].",".$row["email"];
                $uss[12]=$uss[12].",".$row["IdMunicipio"];
                $uss[13]=$uss[13].",".$row["IdCargo"];
               $uss[14]=$uss[14].",".$row["CODIGO_POSTAL"];
                // $uss[15]=$uss[15].",".$row["es_suplente_de"];
            }
            $uss[0]=substr($uss[0], 1, strlen($uss[0]));
	    $uss[1]=substr($uss[1], 1, strlen($uss[1]));
            $uss[2]=substr($uss[2], 1, strlen($uss[2]));
	    $uss[3]=substr($uss[3], 1, strlen($uss[3]));
            $uss[4]=substr($uss[4], 1, strlen($uss[4]));
	    $uss[5]=substr($uss[5], 1, strlen($uss[5]));
            $uss[6]=substr($uss[6], 1, strlen($uss[6]));
	    $uss[7]=substr($uss[7], 1, strlen($uss[7]));
            $uss[8]=substr($uss[8], 1, strlen($uss[8]));
	    $uss[9]=substr($uss[9], 1, strlen($uss[9]));
            $uss[10]=substr($uss[10], 1, strlen($uss[10]));
	    $uss[11]=substr($uss[11], 1, strlen($uss[11]));
            $uss[12]=substr($uss[12], 1, strlen($uss[12]));
            $uss[13]=substr($uss[13], 1, strlen($uss[13]));
            $uss[14]=substr($uss[14], 1, strlen($uss[14]));
             // $uss[15]=substr($uss[15], 1, strlen($uss[15]));
            return $uss;
        }
        
	public function datosPersonales($casa,$celular,$email,$ce){
	    require("settings.php");
	     $c="";
            if($casa=="")
            $c="CASA";
            else
            $c ="'".$casa."'";
            
            $cel="";
            if($celular=="")
            $cel="CELULAR";
            else
            $cel="'".$celular."'";
            
            $mail="";
            if($email=="")
            $mail="email";
            else
            $mail="'".$email."'";
            $msquery=" UPDATE PADRON_DATOS_PERSONALES SET CASA=".$c.",CELULAR=".$cel.",email=".$mail." WHERE CLAVE_ELECTORAL='".$ce."'; ";
             $msresults=mssql_query($msquery);
	}
	
	
	
	
	
	
	
	public function altaPersona($Nombre,$Paterno,$Materno,$Calle,$NumeroExt,$NumeroInt,$Colonia,$idMunicipio,$idSeccion,$CLAVE_ELECTORAL,$idCargo,$idConsejoPolitico,$es_suplente_de,$id_usuario){
	   if(ISSET($_COOKIE["TIPOC"])){
		if(strtoupper($_COOKIE["TIPOC"])=="MILITANCIA"){
		    $this->borraPersona($CLAVE_ELECTORAL,'1');
		}
	   }
	   require("settings.php");
	   
	    $msquery="INSERT INTO ".$personas." ( ";
	    $msquery=$msquery." Nombre,Paterno,Materno,Calle,NumeroExt,NumeroInt,Colonia,idMunicipio,idSeccion,CLAVE_ELECTORAL,idCargo";
	    $msquery=$msquery." ,idConsejoPolitico,es_suplente_de,id_usuario) ";
	    $msquery=$msquery." VALUES('".$Nombre."','".$Paterno."','".$Materno."','".$Calle."','".$NumeroExt."','".$NumeroInt."','".$Colonia."','".$idMunicipio."','".$idSeccion."','".$CLAVE_ELECTORAL."','".$idCargo."','".$idConsejoPolitico."',".$es_suplente_de.",'".$id_usuario."');";
	    $msresults=mssql_query($msquery);
	}
	public function getIdSeccion($ce){
	    require("settings.php");
	    $msquery="SELECT IdSeccion  FROM PADRON_ELECTORAL INNER JOIN DATOS_Secciones ON DATOS_Secciones.Seccion=PADRON_ELECTORAL.SECCION WHERE PADRON_ELECTORAL.CLAVE_ELECTORAL='".$ce."'";
	     $msresults=mssql_query($msquery);
	     $idsec="";
	    while($row=mssql_fetch_array($msresults)){
                $idsec=$row["IdSeccion"];
            }
	    return $idsec;
	}
	
	
	
}

?>