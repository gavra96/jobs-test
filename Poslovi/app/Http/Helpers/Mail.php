<?php

namespace App\Http\Helpers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    private $mail;
    private $code;
    
    public function __construct() {
        $this->mail = new PHPMailer();
        try {
            $this->mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.gmail.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'netcoreict@gmail.com';
            $this->mail->Password = 'sifra123';
            $this->mail->SMTPSecure = 'tls';
            $this->mail->Port = 587;
        } catch (\Exception $e) {
            echo http_response_code(500);
        }
    }
    function JobPostFirstTime($email){
        try{
            $this->mail->setFrom('netcoreict@gmail.com', 'Test ...');
            $this->mail->addAddress($email);
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Job posting';
            $this->mail->Body = 'Your job is under moderation!';
            $this->mail->send();
            $this->code = 200;
            return $this->code;
        }catch (\PHPMailer\PHPMailer\Exception $e){
            Error::insertError($this->mail->ErrorInfo);
            return $e;
        }
    }
    function ToModeratorJobPost($email, $emailKo, $body){
        try{
            $this->mail->setFrom('netcoreict@gmail.com', 'Test ...');
            $this->mail->addAddress($email);
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Job posting'.$emailKo;
            $this->mail->Body = $body;
            $this->mail->send();
            $this->code = 200;
            return $this->code;
        }catch (\PHPMailer\PHPMailer\Exception $e){
            Error::insertError($this->mail->ErrorInfo);
            return $e;
        }
    }


}
