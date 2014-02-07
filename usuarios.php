<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 5//EN"
    "http://www.w3.org/TR/html5/html5.dtd"
    >
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Usuarios</title>
<link href="menu_source/styles.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
    
    <?php
    require_once("menu.php");
    require_once("bin/controler.php");
    $db=new dbManager();
   $db->configuracion("usuarios.php");
    // Area de Configuracion
    if(ISSET($_POST["id_asigna"])){
        $valida=true;
        $message="";
        if(!$db->valida($_POST["id_asigna"],false)){
            $valida=false;
            $message="Id Invalido";
        }
         if(!$db->valida($_POST["pass"],false)){
            $valida=false;
            $message="password invalido";
        }
         if(!$db->valida($_POST["rol"],true)){
            $valida=false;
            $message="rol invalido";
        }
        if($valida==true){
            $db->asignaRol($_POST["id_asigna"],$_POST["rol"],$_POST["pass"]);
            ?><h2 align="center" class="aviso">Asignado Correctamente</h2><?php
        }else{
            ?><h2 align="center" class="error"><?php echo($message); ?></h2><?php
        }
        
    }
    
    $usuarios=$db->getUsuarios();
    $ids=explode(",",$usuarios[0]);
    $names=explode(",",$usuarios[1]);
    $roles=explode(",",$usuarios[2]);
    $nroles=explode(",",$usuarios[3]);
    $rolesb=$db->getRoles();
    $idrol=explode(",",$rolesb[0]);
    $nrol=explode(",",$rolesb[1]);
    
    ?>
    <br/>
    <center>
        <table align="center" border="1">
        <tr >
            <th style="color:black;">N°</th>
            <th style="color:black;">Nombre</th>
            <th style="color:black;">Rol</th>
            <th style="color:black;">Contraseña</th>
            <th style="color:black;">Asignar Rol</th>
        </tr>
        <?php
        if(!ISSET($_POST["id_edita"])){
            if($ids[0]!=""){
               for($i=0;$i<count($names);$i++){
                    ?>
                   
                    <tr>
                        <td><?php echo($i+1); ?></td>
                          <form action="usuarios.php" method="post" >
                        <td><input type="hidden" name="id_edita" value="<?php echo($ids[$i]); ?>"/>
                   <?php echo($names[$i]); ?></td>
                     <td><?php if($nroles[$i]!=""){ echo($nroles[$i]);}else{echo("Ninguno");} ?></td>
                    <td>**********</td>
                    <td><input type="submit" value="Seleccionar" class="button"/></td>
                          </form>
                    </tr>
                    
                    <?php
               }
            }
        }else {
            if($ids[0]!=""){
                
               for($i=0;$i<count($names);$i++){
                    if($_POST["id_edita"]!=$ids[$i]){
                    ?>
                   
                    <tr>
                         <td><?php echo($i+1); ?></td>
                          <form action="usuarios.php" method="post" >
                        <td><input type="hidden" name="id_edita" value="<?php echo($ids[$i]); ?>"/>
                   <?php echo($names[$i]); ?></td>
                    <td><?php if($nroles[$i]!=""){ echo($nroles[$i]);}else{echo("Ninguno");} ?></td>
                    <td>**********</td>
                    <td><input type="submit" class="button" value="Seleccionar"/></td>
                          </form>
                    </tr>
                    
                    <?php
                    }else{
                          ?>
                          
                    <tr >
                         <td class="selected"><?php echo($i+1); ?></td>
                          <form action="usuarios.php" method="post" >
                        <td class="selected"><input type="hidden" name="id_asigna" value="<?php echo($ids[$i]); ?>"/>
                   <?php echo($names[$i]); ?></td>
                    <td class="selected">
                    <select name="rol" class="sel" >
                    <?php
                        for($j=0;$j<count($nrol);$j++){
                            ?>
                            <option value="<?php echo($idrol[$j]); ?>" <?php if($idrol[$j]==$roles[$i]){ echo(" selected ");} ?> ><?php echo($nrol[$j]); ?></option>
                            <?php
                        }
                    ?>
                    </select>
                    <?php
                    //echo($roles[$i]);
                    ?></td>
                    <td class="selected"><input type="password" name="pass" value=""/></td>
                    <td class="selected"><center><input type="submit" class="button" value="Asignar"/></center></td>
                          </form>
                    </tr>
                          
                    <?php
                        
                    }
               }
            }
        }
        ?>
    </table>
    </center>
</body>
</html>