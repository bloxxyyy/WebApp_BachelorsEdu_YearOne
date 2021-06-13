<?php

/***
 * Om rubrieken op te laden uit de database.
 *
 * Class RubriekModel
 */
class RubriekModel extends Model {

    /**
     * Pak 1 Rubriek bij zijn parent rubriek.
     * @param $id
     * @return array
     */
    public function GetRubriekenByRubriekId($id) : array {
        $db = $this->DB();

        $data = [];
        $sql = "SELECT rubrieknummer, Rubrieknaam FROM Rubriek WHERE Rubriek IS NULL";

        // If no child is set we get the head rubrieks.
        $id = intval($id);
        if ($id != null) {
            if (!is_int($id)) return [];
            $data = [":id" => $id];
            $sql = "SELECT rubrieknummer, Rubrieknaam FROM Rubriek WHERE Rubriek = :id";
        }


        $stmt = $db->prepare($sql);
        $stmt->execute($data);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result == false) {
            $result = [];
            error_log("GetRubriekenByRubriekId() returns false!");
        }

        return $result;
    }

    /**
     * Pak alle rubrieken waar rubriek parent niet null is
     * @return array|mixed
     */
    public function GetAllNonBaseRubrieks() {
        $db = $this->DB();
        $sql = "SELECT Rubrieknummer, Rubrieknaam FROM Rubriek WHERE Rubriek IS NOT NULL ORDER BY Rubrieknaam";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result == false) {
            $result = [];
            error_log("GetAllNonBaseRubrieks() returns false!");
        }
        return $result;
    }

    /**
     * Pak 1 rubriek bij het voorwerp die der aan vast zit.
     * @param int $id
     * @return array
     */
    public function GetRubriekIdByProductId(int $id) : array {
        $db = $this->DB();
        $sql = "SELECT RubriekOpLaagstNiveau FROM VoorwerpInRubriek WHERE Voorwerp = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([":id" => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == false) {
            $result = [];
            error_log("GetRubriekIdByProductId() returns false!");
        }
        return $result;
    }


    /**
     * Get random rubrieks by amount.
     * @param int $amount
     * @return array
     */
    public function GetRandomRubrieks(int $amount) : array {
        $db = $this->DB();
        $sql = "SELECT TOP " . $amount . " r.Rubrieknummer, r.Rubrieknaam FROM Rubriek as r LEFT JOIN VoorwerpInRubriek as vir ON vir.RubriekOpLaagstNiveau = r.Rubrieknummer LEFT JOIN Voorwerp as v ON v.Voorwerpnummer = vir.Voorwerp WHERE Rubriek IS NOT NULL AND DATEDIFF(second, getdate(), CAST(LooptijdeindeDag AS DATETIME) + CAST(LooptijdEindeTijdstip AS DATETIME)) > 0 AND v.VeilingGesloten = 0 GROUP by r.Rubrieknummer, r.Rubrieknaam HAVING COUNT(vir.Voorwerp) > 0 ORDER BY NEWID();";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) < 4) {
            error_log("Count is lower than $amount GetRandomRubrieks");
        }
        return $result;
    }


    /**
     * @param $maxrubrieken
     * pak rubrieken bij een hoeveelheid.
     * @return array
     */
    public function GetRubrieken($maxrubrieken) {
        $db = $this->DB();
        $sql = "SELECT TOP ".$maxrubrieken." Rubrieknummer, Rubrieknaam FROM Rubriek WHERE Rubriek IS NULL";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * @param $rubriekId
     * Een functie die zichzelf herhaald totdat de hele boom is afgegaan.
     * @return array
     */
    public function GetBreadcrum($rubriekId) : array {
        if ($rubriekId == null) return [];
        $rubriekId = intval($rubriekId);
        if (!is_int($rubriekId)) return [];

        $db = $this->DB();
        $sql = "WITH GetParents as(SELECT P.Rubrieknummer, P.Rubrieknaam, P.Rubriek FROM Rubriek P WHERE P.Rubrieknummer = :id UNION ALL SELECT P1.Rubrieknummer, P1.Rubrieknaam, P1.Rubriek FROM Rubriek P1 INNER JOIN GetParents M ON M.Rubriek = P1.Rubrieknummer) SELECT * From GetParents";
        $stmt = $db->prepare($sql);
        $stmt->execute([":id" => $rubriekId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results == false) {
            error_log("GetBreadcrum() got false");
            $results = [];
        }
        return $results;
    }

    /**
     * @param $rubriek
     * Een herhalende sql functie om alle kinderen te pakken.
     * @return array
     */
    public function GetChildRubrieksByRubriek($rubriek) {
        $db = $this->DB();

        $sql = "WITH CTE AS (SELECT Rubrieknummer, Rubriek AS RubriekItems FROM Rubriek WHERE Rubriek = :id UNION ALL SELECT t.Rubrieknummer, t.Rubriek AS RubriekItems FROM Rubriek t INNER JOIN CTE c ON t.Rubriek = c.Rubrieknummer) SELECT * FROM CTE ORDER BY Rubrieknummer";

        $stmt = $db->prepare($sql);
        $stmt->execute([":id" => $rubriek]);
        $arrays = $stmt->fetchAll();

        $ids = [];
        foreach ($arrays as $array) {
            array_push($ids, $array["Rubrieknummer"]);
        }

       return $ids;
    }

    /**
     * @param null $parentId
     * Pakt alle rubrieken bij parent en zet ze in lijsten van 4.
     * @return array
     */
    public function GetItemsByParent($parentId = null) {

        $db = $this->DB();
        $sql = ($parentId != null)
            ? "SELECT Rubrieknummer, Rubrieknaam FROM Rubriek where Rubriek = :id"
            : "SELECT Rubrieknummer, Rubrieknaam FROM Rubriek where Rubriek is null";

        $stmt = $db->prepare($sql);

        if ($parentId != null) $stmt->execute([":id" => $parentId]);
        else $stmt->execute();

        $cols = $stmt->fetchAll();

        $listOfLists = [];
        $list = [];
        for($i = 1; $i < count($cols) + 1; $i++) {
            array_push($list, $cols[$i - 1]);

            if ($i % 4 == 0) {
                array_push($listOfLists, $list);
                $list = [];
            }
        }
        // get all left over items
        array_push($listOfLists, $list);

        return $listOfLists;
    }
}
