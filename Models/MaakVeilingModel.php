<?php
class MaakVeilingModel extends Model {

    /**
     * Om een veiling aan te maken.
     * @param $gebruiker
     * @param $veilingArray
     * @param $image
     * @param $gebruiker
     */
    public function insertVeiling($verkoopprijs, $titelVeiling, $beschrijvingVeiling, $landVeiling, $plaatsnaamVeiling, $startprijsVeiling, $verzendkostenVeiling, $rubriekVeiling, $betalingswijzeVeiling, $looptijdVeiling, $postcodeVeiling, $betalingInstructiesVeiling, $verzendinstructiesVeiling, $image, $gebruiker, $postCode) {
        $currentTime = date("H:i:s");
        $currentDate = date("Y-m-d");
        $looptijd = (int)filter_var($looptijdVeiling, FILTER_SANITIZE_NUMBER_INT);
        $time = strtotime(date('Y-m-d', strtotime(strval($currentTime). " " . strval($looptijd) . ' days')));

        $data = [
            ":Titel"                    => $titelVeiling,
            ":Beschrijving"             => $beschrijvingVeiling,
            ":Startprijs"               => $startprijsVeiling,
            ":Betalingswijze"           => $betalingswijzeVeiling,
            ":Betalingsinstructie"      => $betalingInstructiesVeiling,
            ":Plaatsnaam"               => $plaatsnaamVeiling,
            ":Land"                     => $landVeiling,
            ":Looptijd"                 => $looptijd,
            ":LooptijdbeginDag"         => $currentDate,
            ":LooptijdbeginTijdstip"    => $currentTime,
            ":Verzendkosten"            => $verzendkostenVeiling,
            ":Verzendinstructies"       => $verzendinstructiesVeiling,
            ":Verkoper"                 => $gebruiker,
            ":Koper"                    => NULL,
            ":LooptijdeindeDag"         => date('Y-m-d', $time),
            ":LooptijdEindeTijdstip"    => $currentTime,
            ":VeilingGesloten"          => 0,
            ":Verkoopprijs"             => $verkoopprijs,
            ":Postcode"                 => $postCode
        ];
        $db = $this->DB();
        $sql = "INSERT INTO Voorwerp (Titel, Beschrijving, Startprijs, Betalingswijze, Betalingsinstructie, Plaatsnaam, Land, Looptijd, LooptijdbeginDag, LooptijdbeginTijdstip, Verzendkosten, Verzendinstructies, Verkoper, Koper, LooptijdeindeDag, LooptijdEindeTijdstip, VeilingGesloten, Verkoopprijs, Postcode) VALUES (:Titel, :Beschrijving, :Startprijs, :Betalingswijze, :Betalingsinstructie, :Plaatsnaam, :Land, :Looptijd, :LooptijdbeginDag, :LooptijdbeginTijdstip, :Verzendkosten, :Verzendinstructies, :Verkoper, :Koper, :LooptijdeindeDag, :LooptijdEindeTijdstip, :VeilingGesloten, :Verkoopprijs, :Postcode)";
        $stmt = $db->prepare($sql);
        $stmt->execute($data);

        $result = $this->GetLastMadeRecord();

        $rubriek = $rubriekVeiling;
        $db = $this->DB();
        $sql = "INSERT INTO VoorwerpInRubriek (Voorwerp, RubriekOpLaagstNiveau) VALUES (:Voorwerp, :RubriekOpLaagstNiveau)";
        $stmt = $db->prepare($sql);
        $stmt->execute([":Voorwerp" => $result["Voorwerpnummer"], "RubriekOpLaagstNiveau" => $rubriek]);

        foreach ($image as $img) {
            $db = $this->DB();
            $sql = "INSERT INTO Bestand (Filenaam, Voorwerp) VALUES (:Filenaam, :Voorwerp)";
            $stmt = $db->prepare($sql);
            $stmt->execute([":Filenaam" => $img, "Voorwerp" => $result["Voorwerpnummer"]]);
        }
    }

    /**
     * @param $gebruiker
     * @return mixed
     */
    public function GetGebruikerPostcode($gebruiker) {
        $db = $this->DB();
        $sql = "SELECT TOP 1 Postcode FROM Gebruiker WHERE Gebruikersnaam = :gebruiker ";
        $stmt = $db->prepare($sql);
        $stmt->execute([":gebruiker" => $gebruiker]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get last made Voorwerp.
     * @return mixed
     */
    private function GetLastMadeRecord() {
        $db = $this->DB();
        $sql = "SELECT TOP 1 Voorwerpnummer FROM Voorwerp ORDER BY Voorwerpnummer DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Check of gebruiker een verkoper is.
     * @param $gebruikerId
     * @return mixed
     */
    public function isGebruikerVerkoper($gebruikerId) {
        $db = $this->DB();
        $sql = "SELECT Verkoper FROM Gebruiker WHERE Gebruikersnaam = :gebruikerId";
        $stmt = $db->prepare($sql);
        $stmt->execute([":gebruikerId" => $gebruikerId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result == false) {
            error_log("isGebruikerVerkoper() gooide false");
            $result["Verkoper"] = null;
        }

        if ($result["Verkoper"] == null) return false;
        return (bool)$result["Verkoper"];
    }
}
