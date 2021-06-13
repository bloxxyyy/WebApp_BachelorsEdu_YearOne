<?php

class VoorwerpModel extends Model {

    /**
     * Pak images bij voorwerp
     * @param $itemId
     * @return array
     */
    public function GetFiles($itemId) {
        if (!is_numeric($itemId)) return [];
        if ($itemId > 9223372036854775807) return []; // max int value
        $db = $this->DB();
        $stmt = $db->prepare("SELECT TOP(3) Filenaam FROM Bestand WHERE Voorwerp = :itemId");
        $stmt->execute([":itemId" => $itemId]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result == false) {
            $result = [];
            error_log("GetFiles() returns false!");
        }
        return $result;
    }

    /**
     * Pak een voorwerp bij id
     * @param $itemId
     * @return array|mixed
     */
    public function getVoorwerp($itemId) {
        if (!is_numeric($itemId)) return false;
        if ($itemId > 9223372036854775807) return false; // max int value
        $db = $this->DB();

        // pak alles van voorwerp en bestands naam als er bestanden zijn toegevoegd.
        $sql = "SELECT *, Bestand.Filenaam
            FROM Voorwerp
            LEFT JOIN Bestand ON Voorwerp.Voorwerpnummer = Bestand.Voorwerp
            WHERE Voorwerpnummer = :itemId";

        $stmt = $db->prepare($sql);
        $stmt->execute([":itemId" => $itemId]);
        $result = $stmt->fetch();
        if ($result == false) {
            $result = [];
            error_log("getVoorwerp() returns false!");
        }
        return $result;
    }

    /**
     * Pak alle biedingen bij een item.
     * @param $itemId
     * @return array
     */
    public function getBiedingen($itemId) {
        $db = $this->DB();

        $sql = "SELECT TOP (5) * FROM Bod WHERE Voorwerp = :itemId ORDER BY BodBedrag DESC";

        $stmt = $db->prepare($sql);
        $stmt->execute([":itemId" => $itemId]);

        if (!empty($stmt)) {
            return $stmt->fetchAll();
        }
    }

    /**
     * Voeg een bod toe aan een product.
     * @param $gebruiker
     * @param $bedrag
     * @param $datum
     * @param $gebruiker
     * @param $tijd
     * @param $itemId
     */
    public function insertBod($bedrag, $datum, $gebruiker, $tijd, $itemId) {
        $db = $this->DB();
        $sql = "INSERT INTO Bod (Bodbedrag, BodDag, Gebruiker, BodTijdstip, Voorwerp) VALUES (:bedrag, :datum, :gebruiker, :tijd, :itemId)";
        $stmt = $db->prepare($sql);
        $stmt->execute([":bedrag" => $bedrag, ":datum" => $datum, ":gebruiker" => $gebruiker, ":tijd" => $tijd, ":itemId" => $itemId]);
    }

    /**
     * Update voorwerp by voorwerpnummer
     * @param $gebruiker
     * @param $voorwerp
     */
    private function AddKoperToVoorwerp($gebruiker, $voorwerp) {
        $db = $this->DB();
        $sql = "UPDATE Voorwerp SET Koper = :Koper WHERE Voorwerpnummer = :nummer";
        $stmt = $db->prepare($sql);
        $stmt->execute([":Koper" => $gebruiker, ":nummer" => $voorwerp]);
    }

    /**
     * Sluit een veiling.
     * @param $itemId
     */
    public function sluitVeiling($itemId) {
        $db = $this->DB();

        $sql = "UPDATE Voorwerp SET VeilingGesloten=:VeilingGesloten WHERE Voorwerpnummer = :itemId";

        $stmt = $db->prepare($sql);
        $stmt->execute([":VeilingGesloten" => 1, ":itemId" => $itemId]);
    }
}
?>