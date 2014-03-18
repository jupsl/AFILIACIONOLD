<?php
if(isset($_FILES["fotoUp"])&&isset($_POST["ce"])){
    if(is_uploaded_file($_FILES["fotoUp"]["tmp_name"])){
         // echo("si esta");
         $id=0;
        if(ISSET($_COOKIE["idfoto"])){
                $id=$_COOKIE["idfoto"]+1;
                setcookie("idfoto",$id);
        }else{
                setcookie("idfoto",0);
        }
         $ClaveElectoral=$_POST["ce"];
           $img_file =$ClaveElectoral.$id.".jpg";
            $tmp_name= $_FILES["fotoUp"]["tmp_name"];
           
            
          $rutafisica="/var/www/html/AFILIACION/snapshots/".$img_file;
          $filename = "snapshots/".$_POST["ce"] .$id. '.jpg';
        if (move_uploaded_file($tmp_name, $rutafisica ))
            {
               
                
               //Redimensionar la Imagen
                $fullName = $rutafisica;//'/anypath/image.jpg';
           list($ow, $oh, $xmime) = getimagesize($fullName);
           $imageSize = filesize($fullName);
           $mime = '';
           if($xmime == 2) $mime = 'image/jpg';
          if($xmime == 3) $mime = 'image/png';
        
        if($mime!='image/jpg'&&$mime!='image/png'){
            unlink($rutafisica);
            ?>
            <script type="text/javascript" >
                alert("No es un archivo de Imagen");
                location.href="altas.php";
            </script>
            <?php
            //header("Location:altas.php");
        }else{
           $f = fopen($fullName,'rb');
           $imageData = fread($f, $imageSize);
           fclose($f);
         
         require_once("bin/controler.php");
         $db= new dbManager();
           $newImage = $db->resizeImage($imageData, 160, 120, 70, 'jpg', $ow, $oh,$fullName);
               $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $filename;
//$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/show_image.php' ;
            setcookie("myimage",$url);
            header("Location:altas.php");
            }
            }
         }
}
?>