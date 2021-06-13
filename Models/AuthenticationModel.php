<?php

/**
 * Het laden van Registratie en Gebruiker gegevens.
 * Class AuthenticationModel
 */
class AuthenticationModel extends Model {

    /**
     * Pak de gebruiker bij email adress en return een array.
     * @param $email
     * @return array|mixed
     */
    public function getUserByEmail($email){
        $db = $this->DB();
        $stmt = $db->prepare("SELECT Voornaam, Mailbox, Wachtwoord, Gebruikersnaam FROM Gebruiker WHERE Mailbox = :email");
        $stmt->execute([":email" => $email]);
        $result = $stmt->fetch();

        if ($result == false) {
            error_log("getUserByEmail() niemand met email: ".$email." gevonden");
            $result = [];
        }
        return $result;
    }

    /**
     * Pak email adres van registratie.
     * @param $email
     * @return mixed
     */
    public function getEmail($email){
        $db = $this->DB();
        $stmt = $db->prepare("SELECT Mailbox FROM Registratie WHERE Mailbox = :email");
        $stmt->execute([":email" => $email]);
        return $stmt->fetch();
    }

    /**
     * Check of een email bestaat met mee gegeven email adres
     * @param $email
     * @return mixed
     */
    public function getRegister($email){
        $db = $this->DB();
        $stmt = $db->prepare("SELECT Mailbox FROM Gebruiker WHERE Mailbox = :email");
        $stmt->execute([":email" => $email]);
        return $stmt->fetch();
    }

    /**
     * Pak de gebruikers naam om te checken of die bestaat.
     * @param $username
     * @return mixed
     */
    public function getUser($username) {
        $db = $this->DB();
        $stmt = $db->prepare("SELECT Gebruikersnaam FROM Gebruiker WHERE Gebruikersnaam = :Gebruikersnaam");
        $stmt->execute([":Gebruikersnaam" => $username]);
        return $stmt->fetch();
    }

    /**
     * Pak alle vraag nummers.
     * @return array
     */
    public function getQuestionNumber() {
        $db = $this->DB();
        $stmt = $db->prepare("SELECT Vraagnummer FROM Vraag");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Pak alle vraag teksten
     * @return array
     */
    public function getQuestion(){
        $db = $this->DB();
        $stmt = $db->prepare("SELECT TekstVraag FROM Vraag");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Verkoper Models

    /**
     * Check of de credit card gezet is.
     * @param $Creditcard
     * @return bool
     */
    public function CheckVerkoperCreditCard($Creditcard) {
        $data = [':Creditcard' => $Creditcard];
        $sql = 'SELECT Creditcard FROM Verkoper WHERE Creditcard = :Creditcard';
        $db = $this->DB();
        $stmt=$db->prepare($sql);
        $stmt->execute($data);
        $rows = $stmt->fetchColumn();
        if ($rows > 0) {
            return true;
        }
        return false;
    }

    /**
     * Pak de gebruiker bij een verkoper.
     * @param $Gebruiker
     * @return mixed
     */
    public function CheckVerkoperID($Gebruiker) {
        $db = $this->DB();
        $stmt = $db->prepare("SELECT Gebruiker FROM Verkoper WHERE Gebruiker = :Gebruiker");
        $stmt->execute([":Gebruiker" => $_SESSION["Gebruikersnaam"]]);
        return $stmt->fetch();
    }

    /**
     * Check of het bank id gezet is.
     * @param $Bankrekening
     * @return bool
     */
    public function CheckVerkoperBankID($Bankrekening) {
        $data = [':Bankrekening' => $Bankrekening];
        $sql = 'SELECT Bankrekening FROM Verkoper WHERE Bankrekening = :Bankrekening';
        $db = $this->DB();
        $stmt=$db->prepare($sql);
        $stmt->execute($data);
        $rows = $stmt->fetchColumn();
        if ($rows > 0) {
            return true;
        }
        return false;
    }

    /**
     * Check of de hash correct is.
     * @param $Gebruiker
     * @param $hash
     * @return bool
     */
    public function CheckHash($Gebruiker, $hash) {
        $data = [':gebruiker' => $Gebruiker, ':hash' => $hash];
        $sql = 'SELECT Gebruiker, Hash FROM Verkoper
WHERE Gebruiker = :gebruiker AND Verkoper_Hash = :hash';
        $db = $this->DB();
        $stmt=$db->prepare($sql);
        $stmt->execute($data);
        $rows = $stmt->fetch();

        if ($rows > 0) {
            $this->ActivateUser($rows[1]);
            header('Location: /Instellingen?NewUser');
            die;
        }


    }

    /**
     * Als de hash van de verkoper klopt deze accepteren.
     * @param $rows
     */
    public function ActivateUser($rows) {
        $data = [':hash' => $rows];
        $sql = "UPDATE Verkoper SET [Hash]='Geactiveerd' WHERE Verkoper_Hash = :hash";
        $db = $this->DB();
        $stmt=$db->prepare($sql);
        $stmt->execute($data);

        $this->ActivateVerkoperID($_SESSION["Gebruikersnaam"]);
    }

    /**
     * Set de verkoper op actief op basis van gebruikers naam.
     * @param $gebruikersnaam
     */
    private function ActivateVerkoperID($gebruikersnaam) {
        $data = [':gebruikersnaam' => $gebruikersnaam];
        $sql = "UPDATE Gebruiker SET Verkoper='1' WHERE Gebruikersnaam = :gebruikersnaam";
        $db = $this->DB();
        $stmt=$db->prepare($sql);
        $stmt->execute($data);
    }

    /**
     * Create een verkoper.
     * @param $Gebruiker
     * @param $Bank
     * @param $Bankrekening
     * @param $Creditcard
     * @param $ControleOptie
     * @param $Hash
     */
    public function CreateVerkoper($Gebruiker, $Bank, $Bankrekening, $Creditcard, $ControleOptie, $Hash) {
        $Gebruiker = $_SESSION["Gebruikersnaam"];
        $data = [':Gebruiker' => $Gebruiker, ':Bank' => $Bank, ':Bankrekening' => $Bankrekening, ':Creditcard' => $Creditcard, ':ControleOptie' => $ControleOptie, ':Hash' => $Hash];
        $sql = 'INSERT INTO Verkoper (Gebruiker, Bank, Bankrekening, Creditcard, ControleOptie, Verkoper_Hash)
                VALUES(:Gebruiker, :Bank, :Bankrekening, :Creditcard, :ControleOptie, :Hash)';
        $db = $this->DB();
        $stmt=$db->prepare($sql);
        $stmt->execute($data);
    }


    // Register Models

    /**
     * Check of de register gezet is.
     * @param $email
     * @param $hash
     * @return bool
     */
    public function CheckRegister($email, $hash) {
        $data = [':email' => $email, ':hash' => $hash];
        $sql = 'SELECT Mailbox, Hash FROM Registratie WHERE Mailbox = :email AND Hash = :hash';
        $db = $this->DB();
        $stmt=$db->prepare($sql);
        $stmt->execute($data);
        $rows = $stmt->fetch();
        if ($rows > 0) {
            $_SESSION["MailboxRegister"] = $rows[0];
            $_SESSION['Hash'] = $rows[1];
            return true;
        }
        return false;
    }

    /**
     * Maak de register column aan.
     * @param $email
     * @param $Hash
     */
    public function CreateRegister($email, $Hash) {
        $data = [':Mailbox' => $email, ':Hash' => $Hash];
        $sql = 'INSERT INTO Registratie (Mailbox, Hash)
                VALUES(:Mailbox, :Hash)';
        $db = $this->DB();
        $stmt=$db->prepare($sql);
        $stmt->execute($data);
    }

    /**
     * Maak een nieuwe user aan.
     * @param $username
     * @param $Voornaam
     * @param $Achternaam
     * @param $Geboortedatum
     * @param $Plaatsnaam
     * @param $Adres
     * @param $toevoegingen
     * @param $Postcode
     * @param $Land
     * @param $email
     * @param $hash
     * @param $Question
     * @param $Answer
     */
    public function CreateUser($username, $Voornaam, $Achternaam, $Geboortedatum, $Plaatsnaam, $Adres, $toevoegingen, $Postcode, $Land, $email, $hash, $Question, $Answer) {
        $data = [':Gebruikersnaam' => $username, ':Voornaam' => $Voornaam, ':Achternaam' => $Achternaam, ':Adresregel_1' => $Adres, ':Adresregel_2' => $toevoegingen, ':Postcode' => $Postcode
            , ':Plaatsnaam' => $Plaatsnaam, ':Landnaam' => $Land, ':GeboorteDag' => $Geboortedatum,':Wachtwoord' => $hash, ':Mailbox' => $email, ':Vraag' => $Question, ':Antwoordtekst' => $Answer];
        $sql = 'INSERT INTO Gebruiker (Gebruikersnaam, Voornaam, Achternaam, Adresregel_1, Adresregel_2, Postcode, Plaatsnaam, Landnaam, GeboorteDag, Wachtwoord, Mailbox, Vraag, Antwoordtekst, Verkoper)
                VALUES(:Gebruikersnaam, :Voornaam, :Achternaam, :Adresregel_1, :Adresregel_2, :Postcode, :Plaatsnaam, :Landnaam, :GeboorteDag, :Wachtwoord, :Mailbox, :Vraag, :Antwoordtekst, 0 )';
        $db = $this->DB();
        $stmt=$db->prepare($sql);
        $stmt->execute($data);
    }

}
