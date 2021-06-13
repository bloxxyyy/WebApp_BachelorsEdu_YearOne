<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Register extends Controller {
    public function Pagina() {
        if (Authorization::IsLoggedIn()) {
            header('Location: /Home');
            die;
        }

        $this->View("Account/Register/Steps", ["steps" => 1]);
        $this->View("Account/Register/Register");
        $this->View("Default/footer");
    }

    public function Verificatie() {

        if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
            $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
            $hash = filter_input(INPUT_GET, 'hash', FILTER_SANITIZE_STRING);

            $AuthenticationModel = $this->model('AuthenticationModel');
            if(!$AuthenticationModel->CheckRegister($email, $hash)) {
                header('Location: /Register?Fout');
                die;

            }
            else {
                $_SESSION["Hash"] = $email;
                header('Location: /RegisterForm');
                die;
            }


        }
        else{
            header('Location: /Register?Fout');
            die;
        }
    }

    public function DoRegister() {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $validRegister = true;

        if(empty($email)) {
            $validRegister = false;
            header('Location: /Register?Leeg');
            die;
        }

        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $validRegister = false;
            header('Location: /Register?Fout');
            die;
        }
        If($email){
            $AuthenticationModel = $this->model('AuthenticationModel');
            $Check = $AuthenticationModel->getRegister($email);

            If($Check!= null){
                $validRegister = false;
                header('Location: /Register?bestaatAl');
                die;
            }
        }

        $GenerateHash = random_bytes(20);
        $Hash = bin2hex($GenerateHash);

        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';
        $mail = new PHPMailer;
        $mail->SMTPDebug = 3;
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host = 'mail.ip.aimsites.nl';
        $mail->SMTPAuth = false;
        $mail->Port = 21018;
        $mail->setFrom('noreply@eenmaalandermaal.nl', 'EenmaalAndermaal');
        $mail->addAddress(''.$email.'');
        $mail->isHTML(true);
        $mail->Subject = 'Account verificatie';
        $mail->Body = '<b>Beste '.$email.'</b>,<br><br> Om je account te verifieren ga je naar de volgende link: <a href="https://iproject18.ip.aimsites.nl/Register/Verificatie?email='.$email.'&hash='.$Hash.'" target="_blank">https://iproject18.ip.aimsites.nl/Register/Verificatie?email='.$email.'&hash='.$Hash.'</a><br><br>Groetjes, EenmaalAndermaal';
        $mail->AltBody = 'Beste '.$email.', Om je account te verifieren ga je naar de volgende link: https://iproject18.ip.aimsites.nl/Register/Verificatie?email='.$email.'&hash='.$Hash.' Groetjes, EenmaalAndermaal';
        $mail->send();



        $AuthenticationModel = $this->model('AuthenticationModel');
        $AuthenticationModel->CreateRegister($email, $Hash);






        header('Location: /Register?Success');
        die;
    }
}
