<?php

/**
 * Op producten op te laden uit de database.
 *
 * Class ProductModel
 */
class ProductModel extends Model {

    /**
     *  Pak alle veilinger waar $naam verkoper is.
     * @param $naam
     */
    public function GetMySoldProducts($naam) {
        $db = $this->DB();
        $stmt = $db->prepare("SELECT Voorwerpnummer, Titel FROM Voorwerp where Verkoper = :Verkoper");
        $stmt->execute([":Verkoper" => $naam]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result == false) return [];
        return $result;
    }

    /**
     *  Pak alle veilinger waar $naam een bod heeft gedaan.
     * @param $naam
     */
    public function GetMyBidProducts($naam) {
        $db = $this->DB();
        $stmt = $db->prepare("SELECT DISTINCT Voorwerpnummer, Titel FROM Voorwerp INNER JOIN BOD ON BOD.Voorwerp = Voorwerpnummer WHERE BOD.Gebruiker = :naam;");
        $stmt->execute([":naam" => $naam]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result == false) return [];
        return $result;
    }

    /**
     * Pak alle producten bij een Rubriek. en de kinder producten.
     * @param int $id
     * @return array
     */
    public function GetRecursionProductenByRubriekId(int $id) : array {
        $db = $this->DB();
        $stmt = $db->prepare("WITH GetProductsRecursive AS (SELECT Rubrieknummer, Rubriek AS RubriekItems FROM Rubriek WHERE Rubriek = :id UNION ALL SELECT t.Rubrieknummer, t.Rubriek AS RubriekItems FROM Rubriek t INNER JOIN GetProductsRecursive c ON t.Rubriek = c.Rubrieknummer) SELECT v.VeilingGesloten, vir.RubriekOpLaagstNiveau, bs.Filenaam, v.Verkoopprijs, v.Voorwerpnummer, v.Titel, v.Plaatsnaam, MAX(Bod.Bodbedrag) as bod, CASE WHEN MAX(Bod.Bodbedrag) IS NOT NULL AND v.VeilingGesloten = 1 THEN 1 WHEN v.VeilingGesloten = 0 THEN 2 ELSE 0 END AS VeilingStatus FROM Voorwerp as v LEFT JOIN VoorwerpInRubriek as vir ON vir.Voorwerp = v.Voorwerpnummer LEFT JOIN Bod ON v.Voorwerpnummer = Bod.Voorwerp LEFT JOIN Bestand as bs ON bs.Voorwerp = v.Voorwerpnummer WHERE vir.RubriekOpLaagstNiveau IN (SELECT gpr.Rubrieknummer FROM GetProductsRecursive as gpr) OR vir.RubriekOpLaagstNiveau = :rubriek GROUP BY vir.RubriekOpLaagstNiveau, v.Voorwerpnummer, v.Titel, v.Plaatsnaam, v.Verkoopprijs, bs.Filenaam, v.VeilingGesloten");
        $stmt->execute([":id" => $id, ":rubriek" => $id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result == false) $result = [];
        if (empty($result)) error_log("GetRandomProductByRubriek result is empty!");

        $data = [];

        // remove closed veilingen
        foreach ($result as $veiling) {
            if ((int)$veiling["VeilingStatus"] != 0 ) {
                array_push($data, $veiling);
            }
        }

        return $data;
    }

    /**
     * Pak 1 random product bij een rubriek.
     * @param $rubriekId
     * @return array
     */
    public function GetRandomProductByRubriek($rubriekId): array
    {
        $db = $this->DB();
        $stmt = $db->prepare("SELECT TOP 1 Bod.Bodbedrag, Verkoopprijs, Voorwerpnummer, Titel, RubriekOpLaagstNiveau, CONCAT(DATEDIFF(second, getdate(), CAST(LooptijdeindeDag AS DATETIME) + CAST(LooptijdEindeTijdstip AS DATETIME)) / 3600 / 24, 'd ', RIGHT(CONCAT('00', DATEDIFF(second, getdate(), CAST(LooptijdeindeDag AS DATETIME) + CAST(LooptijdEindeTijdstip AS DATETIME)) / 3600 % 24), 2), 'u ', RIGHT(CONCAT('00', DATEDIFF(second, getdate(), CAST(LooptijdeindeDag AS DATETIME) + CAST(LooptijdEindeTijdstip AS DATETIME)) / 60 % 60), 2), 'm ', RIGHT(CONCAT('00',DATEDIFF(second, getdate(), CAST(LooptijdeindeDag AS DATETIME) + CAST(LooptijdEindeTijdstip AS DATETIME)) % 3600 % 60), 2), 's') RemainingTime, Bestand.Filenaam FROM VoorwerpInRubriek INNER JOIN Voorwerp ON Voorwerp.Voorwerpnummer = VoorwerpInRubriek.Voorwerp LEFT JOIN Bestand ON Bestand.Voorwerp = Voorwerp.Voorwerpnummer LEFT JOIN Bod ON Voorwerp.Voorwerpnummer = Bod.Voorwerp WHERE RubriekOpLaagstNiveau = :id AND VeilingGesloten = 0 AND DATEDIFF(second, getdate(), CAST(LooptijdeindeDag AS DATETIME) + CAST(LooptijdEindeTijdstip AS DATETIME)) > 0 AND (Bod.Bodbedrag = (SELECT MAX(Bodbedrag) FROM Bod b2 WHERE b2.Voorwerp = Bod.Voorwerp) OR Bod.Bodbedrag IS NULL) ORDER BY NEWID();");
        $stmt->execute([":id" => $rubriekId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == false) $result = [];
        if (empty($result)) {
            error_log("GetRandomProductByRubriek result is empty!");
        }
        return $result;
    }

    /**
     * Get all recent products by amount.
     * @param int $amount
     * @return array
     */
    public function GetRecentProducts(int $amount) : array {
        if ($amount <= 0) {
            error_log("Amount must be higher than 0! In GetRecentProducts()");
            return [];
        }

        // Eerst pakken we voorwerpen.
        // Dan pakken wij een Bestand als die bestaat.
        // Dan pakken wij het max bod als er een bod is.
        // Bestand en/of bod hoeft niet te bestaan.
        $sql = "SELECT Bod.Bodbedrag, Verkoopprijs, Voorwerpnummer, Titel, CONCAT(DATEDIFF(second, getdate(), CAST(LooptijdeindeDag AS DATETIME) + CAST(LooptijdEindeTijdstip AS DATETIME)) / 3600 / 24, 'd ', RIGHT(CONCAT('00', DATEDIFF(second, getdate(), CAST(LooptijdeindeDag AS DATETIME) + CAST(LooptijdEindeTijdstip AS DATETIME)) / 3600 % 24), 2), 'u ', RIGHT(CONCAT('00', DATEDIFF(second, getdate(), CAST(LooptijdeindeDag AS DATETIME) + CAST(LooptijdEindeTijdstip AS DATETIME)) / 60 % 60), 2), 'm ', RIGHT(CONCAT('00',DATEDIFF(second, getdate(), CAST(LooptijdeindeDag AS DATETIME) + CAST(LooptijdEindeTijdstip AS DATETIME)) % 3600 % 60), 2), 's') RemainingTime, f.Filenaam FROM Voorwerp outer apply (select top(1) Bestand.Filenaam from Bestand  where Voorwerp.Voorwerpnummer=Bestand.Voorwerp) as f LEFT JOIN Bod ON Voorwerp.Voorwerpnummer = Bod.Voorwerp WHERE VeilingGesloten = 0 AND DATEDIFF(second, getdate(), CAST(LooptijdeindeDag AS DATETIME) + CAST(LooptijdEindeTijdstip AS DATETIME)) > 0 AND (Bod.Bodbedrag = (SELECT MAX(Bodbedrag) FROM Bod b2 WHERE b2.Voorwerp = Bod.Voorwerp) OR Bod.Bodbedrag IS NULL) ORDER BY Voorwerpnummer DESC OFFSET 0 ROWS FETCH NEXT CAST(:amount AS INT) ROWS ONLY";
        // Execute query
        $db = $this->DB();
        $stmt = $db->prepare( $sql);
        $stmt->execute([":amount" => $amount]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result == false) {
            error_log("GetRecentProducts() returned false!");
            return [];
        }

        return $result;
    }

    /**
     * @param $id
     *
     * Kijk of er biedingen zitten aan een product.
     *
     * @return bool
     */
    public function ProductHasBids($id) : bool {
        if (!is_numeric($id)) return false;
        $id = intval($id);
        if (!is_int($id)) return false;
        $db = $this->DB();
        $stmt = $db->prepare("SELECT Gebruiker FROM Bod where Voorwerp = :id");
        $stmt->execute([":id" => $id]);
        $result = $stmt->fetch();
        if ($result == false) return false;
        return count($result) > 0;
    }

    /**
     * @param $id
     * Pak de eind looptijd van het product bij ID.
     * @return array
     */
    public function GetSaleDurationByProductId($id) {
        if (!is_numeric($id)) return [];
        $id = intval($id);
        if (!is_int($id)) return [];
        $db = $this->DB();
        $stmt = $db->prepare("SELECT LooptijdeindeDag, LooptijdEindeTijdstip FROM Voorwerp where Voorwerpnummer = :id");
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }
}