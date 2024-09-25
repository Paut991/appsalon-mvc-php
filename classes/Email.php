<?php 

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }
    
    public function enviarConfirmacion(){
        //Crear el objeto email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon', 'AppSalon.com');
        $mail->Subject = 'Confirmación de cuenta';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->email . "</strong> Has creado tu cvuenta en AppSalon, solo debes confirmarla presionando en el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si no creaste esta cuenta, puedes ignorar este mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar el Email
        $mail->send();
    }

    public function enviarInstrucciones(){

           //Crear el objeto email
           $mail = new PHPMailer();
           $mail->isSMTP();
           $mail->Host = $_ENV['EMAIL_HOST'];
           $mail->SMTPAuth = true;
           $mail->Port = $_ENV['EMAIL_PORT'];
           $mail->Username = $_ENV['EMAIL_USER'];
           $mail->Password = $_ENV['EMAIL_PASS'];
   
           $mail->setFrom('cuentas@appsalon.com');
           $mail->addAddress('cuentas@appsalon', 'AppSalon.com');
           $mail->Subject = 'Reestablece tu password';
   
           //Set HTML
           $mail->isHTML(TRUE);
           $mail->CharSet = 'UTF-8';
   
           $contenido = "<html>";
           $contenido .= "<p><strong>Hola " . $this->nombre . "</strong>Has solicitado reestablecer tu password, sigue el siguiente enlace para hacerlo</p>";
           $contenido .= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "'>Reestablecer Password</a></p>";
           $contenido .= "<p>Si no creaste esta cuenta, puedes ignorar este mensaje</p>";
           $contenido .= "</html>";
   
           $mail->Body = $contenido;
   
           //Enviar el Email
           $mail->send();

    }
}