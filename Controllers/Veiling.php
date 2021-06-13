<?php

/**
 * Om een veiling aan te maken.
 * Class Veiling
 */
class Veiling extends Controller {

    /**
     * Tonen van de maak veiling pagina.
     */
    public function Pagina() {
        if (!Authorization::IsLoggedIn()) {
            header('Location: /Home');
            die;
        }

        $gebruiker = $_SESSION['Gebruikersnaam'];
        $veilingModel = $this->Model("MaakVeilingModel");

        // Als gebruiker geen verkoper is redirect.
        if (!$veilingModel->isGebruikerVerkoper($gebruiker)) {
            header('Location: /Instellingen/Pagina?Error=Geen verkoper');
            die;
        }

        $error = null;
        $postcode = $veilingModel->GetGebruikerPostcode($gebruiker)["Postcode"];

        // Bij het sturen van de data.
        if (isset($_POST["btnSubmit"]) && isset($_POST)) {
            $verkoopprijs = filter_input(INPUT_POST, 'Verkoopprijs', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);
            $titelVeiling = filter_input(INPUT_POST, 'titelVeiling', FILTER_SANITIZE_STRING);
            $beschrijvingVeiling = filter_input(INPUT_POST, 'beschrijvingVeiling', FILTER_SANITIZE_STRING);
            $landVeiling = filter_input(INPUT_POST, 'landVeiling', FILTER_SANITIZE_STRING);
            $plaatsnaamVeiling = filter_input(INPUT_POST, 'plaatsnaamVeiling', FILTER_SANITIZE_STRING);
            $startprijsVeiling = filter_input(INPUT_POST, 'startprijsVeiling', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);
            $verzendkostenVeiling = filter_input(INPUT_POST, 'verzendkostenVeiling', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);
            $rubriekVeiling = filter_input(INPUT_POST, 'rubriekVeiling', FILTER_SANITIZE_STRING);
            $betalingswijzeVeiling = filter_input(INPUT_POST, 'betalingswijzeVeiling', FILTER_SANITIZE_STRING);
            $looptijdVeiling = filter_input(INPUT_POST, 'looptijdVeiling', FILTER_SANITIZE_STRING);
            $postcodeVeiling = filter_input(INPUT_POST, 'postcodeVeiling', FILTER_SANITIZE_STRING);
            $betalingInstructiesVeiling = filter_input(INPUT_POST, 'betalingInstructiesVeiling', FILTER_SANITIZE_STRING);
            $verzendinstructiesVeiling = filter_input(INPUT_POST, 'verzendinstructiesVeiling', FILTER_SANITIZE_STRING);

            $verkoopprijs = str_replace(',', '.', $verkoopprijs);
            $startprijsVeiling = str_replace(',', '.', $startprijsVeiling);
            $verzendkostenVeiling = str_replace(',', '.', $verzendkostenVeiling);

            // valideer de input.
            $error = $this->validateInput($verkoopprijs, $titelVeiling, $beschrijvingVeiling, $landVeiling,
            $plaatsnaamVeiling, $startprijsVeiling, $verzendkostenVeiling, $rubriekVeiling, $betalingswijzeVeiling,
            $looptijdVeiling, $postcodeVeiling, $betalingInstructiesVeiling, $verzendinstructiesVeiling);

            // upload de image om de server.
            $uploaded = $this->ImageUpload();
            if (!$uploaded) $error = "File upload is fout gegaan!";

            // insert de veiling als upload gelukt is.
            if ($error == null) {
                $veilingModel->insertVeiling($verkoopprijs, $titelVeiling, $beschrijvingVeiling, $landVeiling, $plaatsnaamVeiling, $startprijsVeiling, $verzendkostenVeiling, $rubriekVeiling, $betalingswijzeVeiling, $looptijdVeiling, $postcodeVeiling, $betalingInstructiesVeiling, $verzendinstructiesVeiling,
                    $_FILES["fileToUpload"]["name"], $gebruiker, $postcode);

                header('Location: /Veiling?success');
            }
        }

        $rubrieken = $this->Model("RubriekModel")->GetAllNonBaseRubrieks();
        $this->View("Veiling", ["Rubrieken" => $rubrieken, "VeilingData" => $_POST, "error" => $error]);
        $this->View("Default/footer");
    }

    /**
     * input validatie voordat dingen naar de database gestuurd worden.
     * @param $verkoopprijs
     * @param $titelVeiling
     * @param $beschrijvingVeiling
     * @param $landVeiling
     * @param $plaatsnaamVeiling
     * @param $startprijsVeiling
     * @param $verzendkostenVeiling
     * @param $rubriekVeiling
     * @param $betalingswijzeVeiling
     * @param $looptijdVeiling
     * @param $postcodeVeiling
     * @param $betalingInstructiesVeiling
     * @param $verzendinstructiesVeiling
     * @return string|null
     */
    private function validateInput($verkoopprijs, $titelVeiling, $beschrijvingVeiling, $landVeiling, $plaatsnaamVeiling, $startprijsVeiling, $verzendkostenVeiling, $rubriekVeiling, $betalingswijzeVeiling, $looptijdVeiling, $postcodeVeiling, $betalingInstructiesVeiling, $verzendinstructiesVeiling) {
        $userError = null;

        if (empty($landVeiling)) $userError = 'Er is geen land geselecteerd.';
        if (empty($plaatsnaamVeiling)) $userError = 'Plaatsnaam is een verplicht veld.';
        if (empty($startprijsVeiling)) $userError = 'Startprijs is een verplicht veld.';
        if (empty($verzendkostenVeiling)) $userError = 'Verzendkosten is een verplicht veld.';
        if (empty($rubriekVeiling)) $userError = 'Er is geen rubriek geselecteerd.';
        if (empty($betalingswijzeVeiling)) $userError = 'Er is geen betaalwijze geselecteerd.';
        if (empty($looptijdVeiling)) $userError = 'Er is geen looptijd geselecteerd.';
        if (!is_numeric($startprijsVeiling)) $userError = 'Startprijs moet een nummer zijn.';
        if (!is_numeric($verzendkostenVeiling)) $userError = 'Verzendkosten moet een nummer zijn.';
        if (!is_numeric($verkoopprijs)) $userError = 'Verkoopprijs moet een nummer zijn.';
        if (empty($titelVeiling)) $userError = 'Titel moet ingevuld zijn.';
        if (empty($postcodeVeiling)) $userError = 'Postcode moet ingevuld zijn.';
        if (empty($plaatsnaamVeiling)) $userError = 'Plaatsnaam moet ingevuld zijn.';
        if (strlen($titelVeiling) < 3 || strlen($titelVeiling) > 18) $userError = 'Titel moet minimaal 3 tekens bevatten en maximaal 18.';
        if (strlen($beschrijvingVeiling) < 30 || strlen($beschrijvingVeiling) > 200) $userError = 'Beschrijving moet minimaal 30 tekens bevatten en maximaal 200';

        return $userError;
    }

    /**
     * Het uploaden van een image in de server.
     * @return bool
     * @throws Exception
     */
    private function ImageUpload() {

        if (empty($_FILES["fileToUpload"]["name"]) || count($_FILES["fileToUpload"]["name"]) > 2) {
            return false;
        }

        // Voor elke geuploade file.
        for ($x = 0; $x < count($_FILES["fileToUpload"]["name"]); $x++) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$x]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // zorg dat alleen jpg, png en jpeg bestanden ingevoerd kunnen worden.
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                return false;
            }

            // set de naam van de file in een hash.
            $_FILES["fileToUpload"]["name"][$x] = bin2hex(random_bytes(16)) . ".png";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$x]);

            // Als file bestaat en de grote minder is dan 1mb per file.
            if (file_exists($target_file) && $_FILES["fileToUpload"]["size"][$x] > 1000000) {
                return false;
            }

            // upload de file.
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$x], __DIR__ . "/../" . $target_file);
        }

        return true;
    }
}
