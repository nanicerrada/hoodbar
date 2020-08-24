<?php

ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

?>
<?php
include './phpmailer/class.phpmailer.php';

function GetIP()
{
	if (getenv("HTTP_CLIENT_IP")) {
		$ip = getenv("HTTP_CLIENT_IP");
	} elseif (getenv("HTTP_X_FORWARDED_FOR")) {
		$ip = getenv("HTTP_X_FORWARDED_FOR");
		if (strstr($ip, ',')) {
			$tmp = explode(',', $ip);
			$ip = trim($tmp[0]);
		}
	} else {
		$ip = getenv("REMOTE_ADDR");
	}
	return $ip;
}
$ip_adress 		= GetIP();
$name			= addslashes(strip_tags($_POST['name']));
$email			= addslashes(strip_tags($_POST['email']));
$phone			= addslashes(strip_tags($_POST['phone']));
$message		= addslashes(strip_tags($_POST['message']));
$date			= addslashes(strip_tags($_POST['date']));
$time			= addslashes(strip_tags($_POST['time']));
$people			= addslashes(strip_tags($_POST['people']));

if (empty($email)) {
	header("Location:form.php?empty");
} else {

    	$mail 				= new PHPMailer();
    	//$mail->SMTPDebug = 3;        
    	$mail->IsSMTP();
    	$mail->Host     	= "gmail.com"; // smtp host
    	$mail->Port     	= "587";  // Port
    	$mail->SMTPAuth 	= true;
    	$mail->SMTPSecure 	= "tls";
    	$mail->Username 	= "hoodcba@gmail.com";  //mail address
    	$mail->Password 	= "oktubre17"; //email password
        $mail->From = 'hoodcba@gmail.com';
        $mail->FromName = 'HOOD BAR';
        $mail->Subject = 'Contacto HOOD BAR';
        $mail->isHTML(true);
        $mail->Body         = "	Nombre : " . $name . "
        	<br>E mail: " . $email . "
        	<br>teléfono " . $phone . "
			<br>Mensaje " . $message . "
			<br>dia	 " . $date . "
			<br>horario " . $time . "
			<br>cantidad " . $people . "
        	<br>Asunto: Informacion
        	<br>IP : " . $ip_adress;
    	$mail->AddReplyTo("hoodcba@gmail.com", "Contact Form");
    	$mail->AddAddress('hoodcba@gmail.com');  //mail address
    	$mail->IsHTML(true); 

	if ($mail->send()){
		$mail->clearAddresses();
		$mail->clearCCs();
		echo json_encode(array("result"=>"enviado"));
	}else{
	    $mail->clearAddresses();
		$mail->clearCCs();
		echo json_encode(array("result"=>"noenviado"));
	}
}
