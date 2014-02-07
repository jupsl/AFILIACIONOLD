<?php

/* JPEGCam Test Script */
/* Receives JPEG webcam submission and saves to local file */
//echo $HTTP_RAW_POST_DATA;
$id=0;
if(ISSET($_COOKIE["idfoto"])){
	$id=$_COOKIE["idfoto"]+1;
	setcookie("idfoto",$id);
}else{
	setcookie("idfoto",0);
}
$filename = "snapshots/".$_COOKIE["ceAfiliado"] .$id. '.jpg';
$result = file_put_contents( $filename, $HTTP_RAW_POST_DATA );
//$jpeg_data = (file_get_contents('php://input'));

//$result=setcookie("myimage",$HTTP_RAW_POST_DATA);
//$result=setcookie("myimage",$jpeg_data);

if (!$result) {
	print "ERROR: Failed to write data to $filename, check permissions\n";
	exit();
}

$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $filename;
//$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/show_image.php' ;
setcookie("myimage",$url);
print "$url\n";

?>