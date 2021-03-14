<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


//Load Composer's autoloader
require '../../vendor/autoload.php';
    function DataLowongan(){
        $sql = "SELECT Id, Judul FROM careesma_job_vacansy ORDER BY Id ASC";
        $query = $GLOBALS['db']->query($sql);
        $r= array();
        while($res = $query->fetch(PDO::FETCH_ASSOC)){
            $r['data'][] = $res;
        }
        return $r;
    }

    function Pesan($pesan){
        $html = "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Pesan Email</title>
        </head>
        <body style='background-color: beige; border: 1px solid #777; width:80%'>
            <header style='width:100%'>
                <center>
                    <img style='max-width:50%;display: block;' src='https://intansejahterautama.co.id/wordpress/wp-content/uploads/2020/09/Logo-HD-blckvv.png'>
                    <small style='font-family: Arial, Helvetica, sans-serif;'>Telpon : (0411) 8944074, Website : <a href='https://intansejahterautama.co.id/'>PT Intan Sejahtera Utama</a>, Alamat : Jl. H.I.A. Saleh Dg. Tompo, Losari, Kec. Ujung Pandang, Kota Makassar, Sulawesi Selatan 90113</small>
                    <hr>
                </center>
                <p style='font-family: Arial, Helvetica, sans-serif;'>{$pesan}</p>
            
            </header>
        </body>
        </html>";
        return $html;
    }

    function DetailData($data){
        $db = $GLOBALS['db'];
        $result = array();
        $row = array(); 
        if(is_array($data)){
            $sql = "SELECT a.*, YEAR(CURDATE()) - YEAR(a.TglLAhir) as Usia  FROM careesma_data_diri a INNER JOIN careesma_lulus b ON a.Id = b.IdUser WHERE b.IdJobVacancy = '$data[IdLowongan]' AND Keterangan = '$data[Ket]'";
            $query = $db->query($sql);
            $JumRow = $query->rowCount();
            $sql = $sql." ORDER BY b.Id DESC";
            $query = $db->query($sql);
            $no=1;
            if($JumRow > 0){
                $result['data_new'] = $no;
                $result['total_data'] = $JumRow;
                while ($res = $query->fetch(PDO::FETCH_ASSOC)) { 
                    $aksi = "<center><input type='checkbox' name='IdUser[]' value='$res[Id]' class='CheckData' onclick='CheckData()'></center>";
                    $res['No'] = $no;
                    $res['TglLahir'] = tgl_indo($res['TglLahir']);
                    $res['TptLahir'] = strtoupper($res['TptLahir']);
                    $res['JK'] = $res['JK'] == "L" ? "Laki-Laki" : "Perempuan";
                    $res['Aksi'] = $aksi;
                    $result['data'][] = $res;
                    $no++;
                }
            }else{
                $result['total_data'] = 0;
                $result['data']='';
            }
            return $result; 
        }
        
    }

    function KirmEmail($data){
        
        //Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        $pesan = Pesan($data['Pesan']);
        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true; 
            $mail->Mailer   = "smtp";
            // $mail->SMTPSecure = false;
            // $mail->SMTPAutoTLS = false;                                  //Enable SMTP authentication
            // $mail->Username   = 'ptintansejahterautama@gmail.com';                     //SMTP username
            // $mail->Password   = 'passwordEmail';                
            $mail->Username   = 'fahmiidrus131@gmail.com';                     //SMTP username
            $mail->Password   = 'Suksesselalu';                               //SMTP password
            $mail->SMTPSecure = "tls";         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;          
                                      //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            // $mail->SMTPOptions = array(
            //     'ssl' => array(
            //         'verify_peer' => false,
            //         'verify_peer_name' => false,
            //         'allow_self_signed' => true
            //     )
            // );
            //Recipients
            $mail->setFrom('ptintansejahterautama@gmail.com', 'ADMIN PT ISMA');
            $mail->addAddress($data['Email'], $data['Nama']); 

            // //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $data['Subjek'];
            $mail->Body    = $pesan;
            $mail->AltBody = strip_tags($pesan);

            $mail->send();
            $msg['status'] = "sukses";
            $msg['pesan'] = "OK";
            return json_encode($msg);
        } catch (phpmailerException $e){
            echo "{$mail->ErrorInfo}";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    function SaveData($data){
        $IdUser = implode(",",$data['IdUser']);
        $sql = "SELECT * FROM careesma_data_diri WHERE Id IN ($IdUser)";
        $query = $GLOBALS['db']->query($sql);
        $row = $query->rowCount();
        $JumlahEmailTerkirim=1;
        if($row > 0){
            while($rs = $query->fetch(PDO::FETCH_ASSOC)){
                $iData['Nama'] = $rs['Nama'];
                $iData['Email'] = $rs['Email'];
                $iData['Subjek'] = $data['Subjek'];
                $iData['Pesan'] = $data['Pesan'];
                $iLowongan['IdLowongan'] = $data['IdLowongan'];
                $iLowongan['IdUser'] = $rs['Id'];
                $iLowongan['Email'] = $rs['Email'];
                $iLowongan['Pesan'] = $data['Pesan'];
                InsertToOutbox($iLowongan);
                KirmEmail($iData);
                $JumlahEmailTerkirim++;
            }
            $dt['status'] = "sukses";
            $dt['pesan'] = $JumlahEmailTerkirim." email berhasl dikirim cek histori pengiriman email";
            return $dt;
        }else{
            $dt['status'] = "error";
            $dt['pesan'] = "Gaga mengirim data.";
            return $dt;
        }
    }


    function InsertToOutbox($data){
        $data['DataLowongan'] = getLowongan($data['IdLowongan']);
        $data['DataUser'] = getUser($data['IdUser']);
        $Tgl = date("Y-m-d H:i:s");
        $sql = "INSERT INTO careesma_pesan_email SET IdLowongan = '$data[IdLowongan]', DataLowongan = '$data[DataLowongan]', IdUser = '$data[IdUser]', Email = '$data[Email]', Pesan = '$data[Pesan]', DataUser = '$data[DataUser]', TglCreate = '$Tgl'";
        $GLOBALS['db']->query($sql);
        return true;
    }

    function getLowongan($Id){
        $sql = "SELECT * FROM careesma_job_vacansy WHERE Id = '$Id'";
        $query = $GLOBALS['db']->query($sql);
        $res = $query->fetch(PDO::FETCH_ASSOC);
        return json_encode($res);
    }

    function getUser($Id){
        $sql = "SELECT * FROM careesma_data_diri WHERE Id = '$Id'";
        $query = $GLOBALS['db']->query($sql);
        $res = $query->fetch(PDO::FETCH_ASSOC);
        return json_encode($res);
    }
   

    
    
   
    
   
    function ShowData($Id){
        $koneksi = $GLOBALS['db'];
        $sql = "SELECT * FROM careesma_job_vacansy WHERE Id = :Id";
        $exc = $koneksi->prepare($sql);
        $exc->bindParam("Id", $Id, PDO::PARAM_INT);
        $exc->execute();
        $dt = $exc->fetch(PDO::FETCH_ASSOC);
        return $dt;
    }


    

?>