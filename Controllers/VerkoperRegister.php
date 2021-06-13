<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Om een verkoper te registreren.
 * Class VerkoperRegister
 */
class VerkoperRegister extends Controller {

    /**
     * Om de verkoper pagina te laden.
     */
    public function Pagina() {
        // Je moet ingelogd zijn.
        if (!Authorization::IsLoggedIn()) {
            header('Location: /Home');
            die;
        }

        $isVerkoper = false;

        // kijk of de gebruikersnaam gezet is.
        if (array_key_exists('Gebruikersnaam', $_SESSION)) {
            $gebruiker = $_SESSION['Gebruikersnaam'];
            $veilingModel = $this->Model("MaakVeilingModel");
            $isVerkoper = $veilingModel->isGebruikerVerkoper($gebruiker);
        }

        if ($isVerkoper) {
            header('Location: /Home');
            die;
        }

        $error = [];

        $post = [];
        if (!empty($_POST)) {
            $post = $_POST;

            // Submit knop
            $error = $this->DoRegister();
            if($error[0]) {
                $post = [];
            }

        }

        $this->View("Account/Login/InstellingenMenu", ["isVerkoper" => $isVerkoper, "links" => 1]);
        $this->View("Account/Login/VerkoperRegister", ["post" => $post, "error" => $error]);
        $this->View("Default/footer");
    }

    private function checkIBAN($iban) {

        /**
         * IBAN Check credit: https://stackoverflow.com/questions/20983339/validate-iban-php
         */

        // Normaliseer input
        $iban = strtoupper(str_replace(' ', '', $iban));

        // Kijk of het voldoet aan het IBAN algoritme
        if (preg_match('/^[A-Z]{2}[0-9]{2}[A-Z0-9]{1,30}$/', $iban)) {
            $Land = substr($iban, 0, 2);
            $check = intval(substr($iban, 2, 2));
            $Bankrekening = substr($iban, 4);

            // Converteer naar nummerieke weergave
            $search = range('A','Z');
            foreach (range(10,35) as $tmp)
                $replace[]=strval($tmp);
            $numstr = str_replace($search, $replace, $Bankrekening.$Land.'00');

            // Bereken de checksum
            $checksum = intval(substr($numstr, 0, 1));
            for ($i = 1; $i < strlen($numstr); $i++) {
                $checksum *= 10;
                $checksum += intval(substr($numstr, $i,1));
                $checksum %= 97;
            }

            return ((98-$checksum) == $check);
        } else
            return false;
    }

    /**
     * Do de registratie van de verificatie.
     * @throws Exception
     */
    public function DoRegister() {
        $Gebruiker = $_SESSION["Gebruikersnaam"];
        $Bank = filter_input(INPUT_POST, 'Bank', FILTER_SANITIZE_STRING);
        $Bankrekening = filter_input(INPUT_POST, 'Bankrekening', FILTER_SANITIZE_STRING);
        $ControleOptie = filter_input(INPUT_POST, 'ControleOptie', FILTER_SANITIZE_STRING);
        $Creditcard = filter_input(INPUT_POST, 'Creditcard', FILTER_SANITIZE_STRING);

        // Het ophalen van de postdata
        $postdata = array_values($_POST);

        // De postdata checken op verschillende vereisten
        for ($index = 0; $index < count($postdata); $index++) {
            if (empty($postdata[$index])){
                return [false, "Error! Je bent een of meerdere velden vergeten in te vullen."];
            }

            else if (strlen($postdata[$index]) < 15 || strlen($postdata[$index]) > 35){
                return [false, "Error! Elk veld mag maximaal 35 karakters bevatten."];
            }
        }

// Error weergaves na het invullen van het formulier
if (!$this->checkIBAN($Bankrekening)) {
    return [false, "Error! Geen geldig IBAN nummer."]; }

        $AuthenticationModel = $this->model('AuthenticationModel');
        if($AuthenticationModel->CheckVerkoperID($Gebruiker)) {
            return [false, "Error! Je bent al een verkoper."];
        }

        if ($AuthenticationModel->CheckVerkoperBankID($Bankrekening)) {
            return [false, "Error! De ingevoerde bankrekening is al in gebruik."];
        }

        if ($AuthenticationModel->CheckVerkoperBankID($Creditcard)) {
            return [false, "Error! De ingevoerde creditcard is al in gebruik."];
        }

        if(!is_numeric($Creditcard)) {
        return [false, "Error! Creditcard mag alleen nummers bevatten."];

        }



        // Het proces dat gebeurt indien de gegevens zijn goedgekeurd
        // Het systeem maakt een hash aan en er wordt een verificatielink gestuurt naar het opgegeven e-mailadres

        $GenerateHash = random_bytes(20);
        $Hash = bin2hex($GenerateHash);
        $Geadresseerde = $_SESSION["Voornaam"];
        $Mailbox = $_SESSION["Mailbox"];

        /**
         * Maak een mail aan en verstuur deze.
         */

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
        $mail->addAddress(''.$Mailbox.'');
        $mail->isHTML(true);
        $mail->Subject = 'Verkoper verificatie';
        $mail->Body = '<b>Beste '.$Geadresseerde.'</b>,<br><br> Om je te verifiëren als verkoper ga je naar de volgende link: <a href="https://iproject18.ip.aimsites.nl/VerkoperRegister/Verificatie?gebruiker='.$Gebruiker.'&hash='.$Hash.'" target="_blank">https://iproject18.ip.aimsites.nl/VerkoperRegister/Verificatie?gebruiker='.$Gebruiker.'&hash='.$Hash.'</a><br><br>Groetjes EenmaalAndermaal';
        $mail->AltBody = 'Beste '.$Geadresseerde.', Om je te verifiëren als verkoper ga je naar de volgende link: https://iproject18.ip.aimsites.nl/VerkoperRegister/Verificatie?gebruiker='.$Gebruiker.'&hash='.$Hash.' Groetjes EenmaalAndermaal';
        $mail->send();

        // Creëer de verkoper
        $AuthenticationModel = $this->model('AuthenticationModel');
        $AuthenticationModel->CreateVerkoper($Gebruiker, $Bank, $Bankrekening, $Creditcard, $ControleOptie, $Hash);

        return [true, "Gelukt! Check je e-mail voor de verificatielink om je te verifiëren als verkoper."];
    }

    /**
     * De gebruiker de verificeren.
     */
    public function Verificatie()
    {
        // Check of er een gebruikersnaam en hash is meegegeven in de URL en sanatize de input
        if (isset($_GET['gebruiker']) && !empty($_GET['gebruiker']) and isset($_GET['hash']) && !empty($_GET['hash'])) {
            $Gebruiker = filter_input(INPUT_GET, 'gebruiker', FILTER_SANITIZE_STRING);
            $hash = filter_input(INPUT_GET, 'hash', FILTER_SANITIZE_STRING);

            // Indien de gegevens van de link overeenkomen met de database

            $AuthenticationModel = $this->model('AuthenticationModel');
            if ($AuthenticationModel->CheckHash($Gebruiker, $hash)) {
                header('Location: /Instellingen?NewUser');
                die;

            // Indien een link niet geldig is
            } else {
                header('Location: /Home');
                die;
            }
        }

            // Onverwachte fout
            header('Location: /Home');
            die;

        }
    }


