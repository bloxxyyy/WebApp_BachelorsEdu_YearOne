<?php

/**
 * Het tonen van de instellingen pagina.
 * Class Instellingen
 */
class Instellingen extends Controller {

    // laad de pagina.
    public function Pagina() {
        if (!Authorization::IsLoggedIn()) {
            header('Location: /Home');
            die;
        }

        $gebruiker = $_SESSION['Gebruikersnaam'];
        $productModel = $this->Model("ProductModel");

        // Wat ik verkoop.
        $MySales = $productModel->GetMySoldProducts($gebruiker);

        // Wat ik op bied.
        $MyBids = $productModel->GetMyBidProducts($gebruiker);

        require_once("Checks/isVerkoper.php");

        $this->View("Account/Login/InstellingenMenu", ["isVerkoper" => $isVerkoper, "links" => 0]);
        $this->View("Account/Login/Instellingen", ["MySales" => $MySales, "MyBids" => $MyBids]);
        $this->View("Default/footer");
    }
}
