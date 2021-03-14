<?php

function Data($Pesan){
	$data ="<table border='1px' cellpadding='0' cellspacing='0' style='width:100%; font-family: Arial, Helvetica, sans-serif;'>
    <tr>
        <td style='padding:5px; text-align: center; background-color: #009688; color: #ffffff;'><h1>KONFIRMASI JADWAL</h1></td>
    </tr>
    <tr>
        <td style='padding:10px;'>
            <p>".$Pesan."</p>
            <table style='width: 100%;' border='0' cellpadding='0' cellspacing='0'>
                
                <tr style='background-color: whitesmoke;'>
                    <td style='padding:8px' width='20%'>Nama Matakuliah</td>
                    <td style='padding:8px' width='5%' align='center'>:</td>
                    <td style='padding:8px'>Data Mining</td>
                </tr>
                <tr>
                    <td style='padding:8px'>Ruangan</td>
                    <td style='padding:8px' align='center'>:</td>
                    <td style='padding:8px'>R 001</td>
                </tr>
                <tr style='background-color: whitesmoke;'>
                    <td style='padding:8px'>Dosen Pengajar</td>
                    <td style='padding:8px' align='center'>:</td>
                    <td style='padding:8px'>Muhammad Arafah., S.Kom., M.T</td>
                </tr>
                <tr>
                    <td style='padding:8px'>Jadwal</td>
                    <td style='padding:8px' align='center'>:</td>
                    <td style='padding:8px'>21 Agustus 2020 Jam 08.00 AM</td>
                </tr>
            </table>
        </td>
    </tr>
</table>";
return $data;
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "phpmailer/library/PHPMailer.php";
require_once "phpmailer/library/Exception.php";
require_once "phpmailer/library/OAuth.php";
require_once "phpmailer/library/POP3.php";
require_once "phpmailer/library/SMTP.php";

    $NamaTo = "Fahmi Idrus";
    $EmailTo = "fahmiidrus131@gmail.com";
    $Pesan = "Berikut Jadwal kuliah anda satu jam kedepan.";
    $Subjek = "Jadwal Mata Kuliah";
	$mail = new PHPMailer;
 
	//Enable SMTP debugging. 
	$mail->SMTPDebug = 0;                               
	//Set PHPMailer to use SMTP.
	$mail->isSMTP();            
	//Set SMTP host name                          
	$mail->Host = "tls://smtp.gmail.com"; //host mail server
	//Set this to true if SMTP host requires authentication to send email
	$mail->SMTPAuth = true;                          
	//Provide username and password     
	$mail->Username = "nurulizzasukardi@gmail.com";   //nama-email smtp          
	$mail->Password = "14081996";           //password email smtp
	//If SMTP requires TLS encryption then set it
	$mail->SMTPSecure = "tls";                           
	//Set TCP port to connect to 
	$mail->Port = 587;                                   
 
	$mail->From = "nurulizzasukardi@gmail.com"; //email pengirim
	$mail->FromName = "ADMIN ICT"; //nama pengirim
 
	 $mail->addAddress($EmailTo, $NamaTo); //email penerima
 
	$mail->isHTML(true);
 
	$mail->Subject = $Subjek; //subject
    $mail->Body    = Data($Pesan); //isi email
	if(!$mail->send()) 
	{
	    echo "Mailer Error: " . $mail->ErrorInfo;
	} 
	else 
	{
	    echo "sukses";
	}

?>
