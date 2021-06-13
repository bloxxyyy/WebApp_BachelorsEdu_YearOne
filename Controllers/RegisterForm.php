<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class RegisterForm extends Controller {
    public function Pagina()
    {
        // if hash is all geactiveerd redirect.
        if (!Authorization::IsHashActivated()) {
            header('Location: /Home');
            die;
        }

        // als je ingelogd bent redirect.
        if (Authorization::IsLoggedIn()) {
            header('Location: /Home');
            die;
        }



            $AuthenticationModel = $this->model('AuthenticationModel');
            $vraagnummer = $AuthenticationModel->getQuestionNumber();
            $vraag = $AuthenticationModel->getQuestion();

            $error = [];

            $post = [];
            if (!empty($_POST)) {
                $post = $_POST;

                // if button submit
                $error = $this->DoRegister();
            }

            $this->View("Account/Register/Steps", ["steps" => 2]);
            $this->View("Account/Register/RegisterForm", ["vraagnummer" => $vraagnummer, "vraag" => $vraag, "post" => $post, "error" => $error]);
            $this->View("Default/footer");

    }

        // return an error or null
        public
        function DoRegister()
        {
            $username = filter_input(INPUT_POST, 'Username', FILTER_SANITIZE_STRING);
            $Voornaam = filter_input(INPUT_POST, 'Name', FILTER_SANITIZE_STRING);
            $Achternaam = filter_input(INPUT_POST, 'Surname', FILTER_SANITIZE_STRING);
            $Geboortedatum = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
            $Plaatsnaam = filter_input(INPUT_POST, 'City', FILTER_SANITIZE_STRING);
            $Adres = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
            $toevoegingen = filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_STRING);
            $Postcode = filter_input(INPUT_POST, 'postalCode', FILTER_SANITIZE_STRING);
            $Land = filter_input(INPUT_POST, 'Country', FILTER_SANITIZE_STRING);
            $email = filter_var($_SESSION["MailboxRegister"], FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            $rePassword = filter_input(INPUT_POST, 're-password', FILTER_SANITIZE_STRING);
            $Question = filter_input(INPUT_POST, 'question', FILTER_SANITIZE_STRING);
            $Answer = filter_input(INPUT_POST, 'answer', FILTER_SANITIZE_STRING);

            $postdata = array_values($_POST);

            for ($index = 0; $index < count($postdata); $index++) {
                if (empty($postdata[$index]) && $index != 6 && $index != 11){
                    return [false, "Error! Je bent een of meerdere velden vergeten in te vullen."];
                }

                else if (strlen($postdata[$index]) > 35){
                    return [false, "Error! Elk veld mag maximaal 35 karakters bevatten."];
                }
            }

            if ( strtotime($Geboortedatum) > strtotime('now') ) {
                return [false, "Datum is ongeldig!"];
            }

            if (strlen($Postcode) > 7) {
                return [false, "Postcode te lang!"];
            }

            if (strlen($username) < 4) {
                return [false, "Error! Je gebruikersnaam heeft minder dan 4 karakters."];
            }

            if (strlen($password) < 6 || strlen($rePassword) < 6) {
                return [false, "Error! Je wachtwoord heeft minder dan 6 karakters."];
            } else if (empty($rePassword)) {
                return [false, "Error! Geen wachtwoord ingevuld."];
            } else if ($password != $rePassword) {
                return [false, "Error! Je wachtwoorden zijn niet hetzelfde."];
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return [false, "Error! e-mail is niet geldig."];
            }

            if ($email != $_SESSION["MailboxRegister"]) {
                return [false, "Error! Er ging iets niet goed, probeer het nog eens."];
            }

            if ($username) {
                $AuthenticationModel = $this->model('AuthenticationModel');
                $Check = $AuthenticationModel->getUser($username);

                if ($Check != null) {
                    return [false, "Error! Gebruikersnaam bestaat al."];
                }
            }



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
            $mail->Subject = 'Succesvolle registratie';
            $mail->Body = '<b>Beste '.$Voornaam.'</b>,<br><br> Je hebt je succesvol geregistreerd bij EenmaalAndermaal met de volgende gegevens:<br>E-mail: '.$email.'<br>Wachtwoord: opgegeven wachtwoord <br><br>Groetjes EenmaalAndermaal';
            $mail->AltBody = 'Beste '.$Voornaam.', Je hebt je succesvol geregistreerd bij EenmaalAndermaal met deze gegevens. E-mail: '.$email.' en Wachtwoord: opgegeven wachtwoord. Groetjes EenmaalAndermaal';
            $mail->send();

            $passwordhash = password_hash($password, PASSWORD_DEFAULT);
            $AuthenticationModel = $this->model('AuthenticationModel');
            $AuthenticationModel->CreateUser($username, $Voornaam, $Achternaam, $Geboortedatum, $Plaatsnaam, $Adres, $toevoegingen, $Postcode, $Land, $email, $passwordhash, $Question, $Answer);

            $email = null;

            session_unset();
            session_destroy();

            header('Location: /Login?NewUser');
            die;


    }
}

