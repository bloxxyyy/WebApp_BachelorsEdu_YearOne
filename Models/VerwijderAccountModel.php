<?php

/**
 * Om accounts te verwijderen. Op basis van cascade deletes word alle data verwijderd.
 * Class VerwijderAccountModel
 */
class VerwijderAccountModel extends Model {

    public function PakAntwoordBijGebruikersnaam($gebruikersnaam) {
        $db = $this->DB();

        $data = [":naam" => $gebruikersnaam];
        $sql = "SELECT Antwoordtekst From Gebruiker WHERE Gebruikersnaam = :naam";

        $stmt = $db->prepare($sql);
        $stmt->execute($data);
        $result = $stmt->fetchColumn();
        if ($result == false) {
            $result = null;
            error_log("PakVraagBijGebruikersnaam() returns false!");
        }

        return $result;
    }

    /**
     * Pak de vraag bij gebruikers naam
     * @param $gebruikersnaam
     * @return mixed|null
     */
    public function PakVraagBijGebruikersnaam($gebruikersnaam) {
        $db = $this->DB();

        $data = [":naam" => $gebruikersnaam];
        $sql = "SELECT Vraag.TekstVraag From Vraag INNER JOIN Gebruiker ON Vraag.Vraagnummer = Gebruiker.Vraag WHERE Gebruikersnaam = :naam";

        $stmt = $db->prepare($sql);
        $stmt->execute($data);
        $result = $stmt->fetchColumn();
        if ($result == false) {
            $result = null;
            error_log("PakVraagBijGebruikersnaam() returns false!");
        }

        return $result;
    }


    /**
     * Verwijder een gebruiker uit de database
     * @param $userId
    */
    public function VerwijderGebruiker($userId) {
        $db = $this->DB();
        $stmt = $db->prepare("DELETE FROM Gebruiker WHERE Gebruikersnaam = :userId");
        $stmt->execute([":userId" => $userId]);
    }
}

?>