<?php

if (array_key_exists('Gebruikersnaam', $_SESSION)) {
    $gebruiker = $_SESSION['Gebruikersnaam'];
    require_once("./Models/MaakVeilingModel.php");
    $veilingModel = new MaakVeilingModel();
    $isVerkoper = $veilingModel->isGebruikerVerkoper($gebruiker);
} else {
    $isVerkoper = false;
}
