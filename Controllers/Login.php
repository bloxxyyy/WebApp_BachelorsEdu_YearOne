<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Om de gebruiker te verificeren.
 * Class Login
 */
class Login extends Controller {

    /**
     * De geladen login pagina.
     */
    public function Pagina() {
        // Redirect als er al ingelogd is.
        if (Authorization::IsLoggedIn()) {
            header('Location: /Home');
            die;
        }

        $email = "";

        $error = null;
        if (!empty($_POST) && $_POST != null) { // if post gezet is.
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
            $error = $this->CheckLogin($email, $password); // check de login.
        }

        $this->View("Account/Login/Login", ["error" => $error, "email" => $email]);
        $this->View("Default/footer");
    }

    /**
     * Check of de login correct is.
     * @param $email
     * @param $password
     * @return string
     */
    private function CheckLogin($email, $password) {
        $authenticationModel = $this->Model('AuthenticationModel');
        $user = $authenticationModel->getUserByEmail($email);

        // als de user bestaat.
        if (!empty($user)) {

            // check of het password correct is.
            if ($this->IsUserPasswordCorrect($user, $password)) {

                // set de sessie's
                $_SESSION["Mailbox"] = $user['Mailbox'];
                $_SESSION["Voornaam"] = $user['Voornaam'];
                $_SESSION["Gebruikersnaam"] = $user['Gebruikersnaam'];
                session_regenerate_id();
                header('Location: /Home');
                die();
            }
        }

        return "Er ging iets mis met het inloggen van je gebruikers account.";
    }

    /**
     * Delete alle gebruikers sessies op logout.
     */
    public function Logout() {
        if (Authorization::IsLoggedIn()){
            $_SESSION["Mailbox"] = NULL;
            $_SESSION["Voornaam"] = NULL;
            $_SESSION["Gebruikersnaam"] = NULL;
            session_destroy();
            session_unset();
        }

        header('Location: /Home');
        die;
    }

    /**
     * Check of het wachtwoordcorrect is via de verify func binnen php.
     * @param $user
     * @param $password
     * @return bool
     */
    private function IsUserPasswordCorrect($user, $password){
        return password_verify($password, $user['Wachtwoord']);
    }
}
