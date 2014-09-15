<?php
//require('common.php');
require('phpqrcode/qrlib.php');

$template_image = 'images/MADCRED2.png';
$im = ImageCreateFromPng($template_image);
$black = imagecolorallocate($im, 0, 0, 0);
$madRed = imagecolorallocate($im, 237, 24, 73);
$phoneNumber = (string)$_POST['phoneNumber'];
$phoneNumberAppended = checkCode($phoneNumber);
ImageTtfText($im, 35, 0, 15, 323, $madRed, "fonts/BebasNeue-webfont.ttf", $_POST['Name']); // Name 
/*Parameters 
	1. Image Vector Variable
	2. Font Size
	3. Inclination (degrees)
	4. X Pos
	5. Y Pos
	6. Color Code
	7. Fonts
	8. String to be placed.
*/
function appendZeros($string,$len){
	$nZ = 6-$len;
	//echo $nZ;
	$zeros="";
	for($i=0;$i<$nZ;$i++){
		$zeros.="0";
	}
	
	$final = $zeros.$string;
	return $final;
}

function checkCode($phone){
	$len = strlen($phone);
	$phoneWithCode = "+91-";
	if($len>10){
		for($i=($len-10);$i<$len;$i++){
			$phoneWithCode.=$phone[$i];
		}
	}
	else{
		$phoneWithCode.=$phone;	
	}
	return $phoneWithCode;
}


$length = strlen($_POST['userID']);
$link = 'www.makeadiff.in/volunteer/'.$_POST['userID'];
$frame = QRcode::text($link, false, QR_ECLEVEL_L, 4,  0); 
$qrcode = get_qrcode($frame);
$idNumber = (string)$_POST['userID'];
$idSixLength = appendZeros($idNumber,$length);
//echo $idSixLength;

ImageTtfText($im, 13, 0, 15, 343, $black, "fonts/BebasNeue-webfont.ttf", $_POST['Post']);
ImageTtfText($im, 15, 0, 48, 382, $black, "fonts/univers.ttf",$phoneNumberAppended ); 
ImageTtfText($im, 15, 0, 48, 410, $black, "fonts/univers.ttf", $_POST['Email']);
ImageTtfText($im, 16, 0, 626.5, 153, $madRed, "fonts/BebasNeue-webfont.ttf", "MAD ID : ");
ImageTtfText($im, 16, 0, 679, 153, $madRed, "fonts/BebasNeue-webfont.ttf", $idSixLength);
ImageTtfText($im, 15, 0, 48, 432, $black, "fonts/univers.ttf", $link); 
imagecopyresampled($im, $qrcode, 626.5, 25, 0, 0, 100, 100, 100, 100);

/*
	Parameters
	1. Final Image
	2. Sampled Image
	3. Start X
	4. Start Y
	5. Source X Point
	6. Source Y Point
	7. Image Width
	8. Image Height
	9. Source Width
	10. Source Height
*/

header('Content-Disposition: attachment; filename='.$_POST['Name'].' Card.png');
header('Pragma: no-cache');
imagepng($im);
imagedestroy($im);

function get_qrcode($frame) {
	$outerFrame = 0;
    $pixelPerPoint = 4;
    
	$h = count($frame);
    $w = strlen($frame[0]);
    
    $imgW = $w + 2 * $outerFrame;
    $imgH = $h + 2 * $outerFrame;
    
    $base_image = imagecreate($imgW, $imgH);
    
    $col[0] = imagecolorallocate($base_image,255,255,255); // BG, white 
    $col[1] = imagecolorallocate($base_image,0,0,0);     // FG, 

    imagefill($base_image, 0, 0, $col[0]);

    for($y=0; $y<$h; $y++) {
        for($x=0; $x<$w; $x++) {
            if ($frame[$y][$x] == '1') {
                imagesetpixel($base_image,$x+$outerFrame,$y+$outerFrame,$col[1]); 
            }
        }
    }
    
    // saving to file
    $target_image = imagecreate($imgW * $pixelPerPoint, $imgH * $pixelPerPoint);
    imagecopyresized(
        $target_image, 
        $base_image, 
        0, 0, 0, 0, 
        $imgW * $pixelPerPoint, $imgH * $pixelPerPoint, $imgW, $imgH
    ); 
	
	return $target_image;
}

?>