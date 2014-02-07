
<div id='cssmenu'>
<ul>
   <li class='active'><a href='login.php'><span>Pagina Principal</span></a></li>
   <li class='has-sub'><a href='#'><span>Afiliacion</span></a>
      <ul>
         <li><a href='altas.php'><span>Alta</span></a></li>
         <li><a href="cred_trasera.php" target="_BLANK"><span>Credencial Trasera</span></a></li>
      </ul>
   </li>
   <li class='has-sub'><a href='#'><span>Administracion</span></a>
      <ul>
         <li class='last'><a href='usuarios.php'><span>Usuarios</span></a></li>
      </ul>
   </li>
   <li><a href='about.php'><span>Acerca de..</span></a></li>
   <li class='last'><a href='contact.php'><span>Contacto</span></a></li>
    <li class='last'><a href='#'><img src="images/LOGO.png" width="20" height="15" />&nbsp;<span>Sistema de Afiliacion Web</span></a></li>
   <?php
   if(ISSET($_COOKIE["USAFI"])){
      ?>
      <li class='last'><a href='#' onclick="document.getElementById('CS').submit();"><span>Cerrar Session<form action="login.php" id="CS" method="post"><input type="hidden" name="cs" value="1"  /></form></span></a></li>
      <?php
   }
   ?>
</ul>
</div>