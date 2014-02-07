<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 5//EN"
    "http://www.w3.org/TR/html5/html5.dtd"
    >
<html lang="es">
<head>
    <title>Iniciar Session</title>
    <link href="menu_source/styles.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
    <?php
    require_once("menu.php");
    require_once("bin/controler.php");
    $db=new dbManager();
    
    if(ISSET($_POST["us"])){
        $uss=$db->autenticar($_POST["us"],$_POST["pw"]);
        $username=$uss[0];
        $userid=$uss[1];
        $rol=$uss[2];
        if($username!=""){
            setcookie("USAFI",$username);
            setcookie("IDAFI",$userid);
            setcookie("ROLAFI",md5($rol));
            if(ISSET($_COOKIE["PAGEAFI"])){
                header('Location: '.$_COOKIE['page']);
            }else{
                header('Location: login.php');
            }
        }else{
            ?>
            <center><h2>Fallo al Autenticar</h2></center>
            <?php
        }
    }
    if(ISSET($_POST["cs"])){
	 $db->borraCokkiesAfiliado();
        setcookie("USAFI","");
            setcookie("IDAFI","");
            setcookie("ROLAFI","");
            setcookie("PAGEAFI","");
	    //--------cambios
	    setcookie("IDPERSONA","");
	    setcookie("idmun","");
	    setcookie("nmun","");
	    setcookie("cargo","");
	    //-------------altas
	    setcookie("CARGO","");
	    setcookie("MUNA","");
	    setcookie("TIPOCARGO","");
	    setcookie("TIPOC","");
	   /* foreach (@$_COOKIE as $key => $valor){
	    	@$_COOKIE[$key] = '';
		unset($_COOKIE[$key]);
	    }*/
        header('Location: login.php');
    }
    
    if(!ISSET($_COOKIE["USAFI"])){
        
        ?>
        <br/>
        <center>
        <form action="login.php"  method="post" >
<table class="logintable" align="center" border="1"   >
<tr>
<td><div class="titulologin">USUARIO</div></th><th><input type="text" name="us" class="uslogin"/></td>

</tr>
<tr>
<td><div class="titulologin">PASSWORD</div></th><th><input type="password" name="pw" class="pwlogin"/></td>
</tr>
<tr>
<td  align="center"><center><img src="images/LOGO.png" alt="" width="50 height="50" class="imagelogin"></center></td>
<td align="center" >
<center><input type="submit" value="ENTRAR" class="button"/></center>
</td>
</tr>

</table>
</form>
        </center>
        <?php
    }else{
        
        
        ?>
        <br/>
        <center>
        <form action="login.php"  method="post" >
	<table class="logintable" align="center" border="1">
	<tr><td><div class="titulologin">BIENVENIDO&nbsp;<?php echo($_COOKIE["USAFI"]); ?>  </div></td></tr>
	<tr><td align="center"><center><input type="submit" value="Cerrar Session" name="cs" class="button"/></center></td></tr>
	</table>
	
	</form>
        </center>
        <?php
    }
    
    ?>
</body>
</html>
