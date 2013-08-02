<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$targ_w = $_POST['w'];
        $targ_h = $_POST['h'];
        
	$jpeg_quality = 100;

	$src = '../../img/examples/photo/example_4.jpg';
	$img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'], $targ_w, $targ_h, $_POST['w'],$_POST['h']);

	header('Content-type: image/jpeg');
	imagejpeg($dst_r,null,$jpeg_quality);
}
?>