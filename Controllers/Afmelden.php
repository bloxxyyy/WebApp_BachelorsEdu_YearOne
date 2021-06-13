<?php

require 'Login.php';

/**
 * Volgens de AVG gebruikers verwijderen.
 * Class Afmelden
 */
class Afmelden extends Controller {

    /**
     * De afmeld pagina tonen.
     */
    public function Pagina() {
        if (!Authorization::IsLoggedIn()) {
            header('Location: /Home');
            die;
        }

        $foutmelding = null;
        if (array_key_exists('fout', $_GET)) {
            $foutmelding = "Incorrect Antwoord op vraag!";
        }

        $userId = $_SESSION['Gebruikersnaam'];
        $verwijderAccountModel = $this->Model("VerwijderAccountModel");
        $vraag = $verwijderAccountModel->PakVraagBijGebruikersnaam($userId);

        require_once("Checks/isVerkoper.php");
        $this->View("Account/Login/InstellingenMenu", ["isVerkoper" => $isVerkoper, "links" => 2]);
        $this->View("Account/Login/Afmelden", ["fout" => $foutmelding, "vraag" => $vraag]);
        $this->View("Default/footer");
    }

    /**
     * Het verwijderen van je account.
     */
    public function VerwijderAccount() {

        // pak je user sessie.
        $userId = $_SESSION['Gebruikersnaam'];
        $verwijderAccountModel = $this->Model("VerwijderAccountModel");
        $antwoord = $verwijderAccountModel->PakAntwoordBijGebruikersnaam($userId);

        $Antwoord = filter_input(INPUT_POST, 'Antwoord', FILTER_SANITIZE_STRING);

        if ($antwoord == $Antwoord) {
            // verwijder het account gekoppeld aan de sessie.
            $verwijderAccountModel->VerwijderGebruiker($userId);
            session_destroy();
            header('Location: /Login/Logout');
        } else {
            header('Location: /Afmelden?fout');
        }

        die;
    }
}
