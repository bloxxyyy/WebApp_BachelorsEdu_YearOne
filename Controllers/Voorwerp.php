<?php

/**
 * Om een voorwerp pagina te tonen.
 * Class Voorwerp
 */
class Voorwerp extends Controller {

    /**
     * Eerste aanspreek punt van de webpagina. url.com/Voorwerp/Pagina
     * @param $args
     * @throws Exception
     */
    public function Pagina($args) {
        // als er geen id mee is gegevens in de url bar redirecten we naar de homepage.
        if (count($args) < 1 || !is_numeric($args[0])) {
            header('Location: /Home');
            die;
        }

        $voorwerp = $args[0];
        $rubriekModel = $this->Model("RubriekModel");
        $itemModel = $this->Model("VoorwerpModel");

        // Pak het voorwerp data.
        $item = $itemModel->getVoorwerp($voorwerp);
        $images = $itemModel->GetFiles($voorwerp);

        if (empty($item)) {
            header('Location: /Home');
            die;
        }

        // pak de biedingen.
        $bod = $itemModel->getBiedingen($voorwerp);

        // laad de breadcrum.
        $id = $rubriekModel->GetRubriekIdByProductId($voorwerp);
        $breadcrum = array_reverse($rubriekModel->GetBreadcrum($id["RubriekOpLaagstNiveau"]));

        // kijk of de veiling open is.
        $veilingOpen = (!$item["VeilingGesloten"])
            ? $this->IsActionBiddable($itemModel, $item)
            : false;

        $tijd = $this->calculateLooptijd($item['LooptijdbeginDag'], $item['LooptijdeindeDag'], $item['LooptijdbeginTijdstip'], $item['LooptijdEindeTijdstip']);

        // kijk of er een bieding gedaan is.
        $this->CheckBidPosted($veilingOpen, $itemModel, $bod, $item);

        // laad de html.
        $this->View("Voorwerp", ["images" => $images, "breadcrum" => $breadcrum, "Loggedin" => Authorization::IsLoggedIn(), "Voorwerp" => $item, "Bod" => $bod, "Looptijd" => $tijd, "VeilingOpen" => $veilingOpen]);
        $this->View("Default/footer");
    }

    /**
     * Te kijken of er een bieding gedaan is.
     * @param $veilingOpen
     * @param $itemModel
     * @param $bod
     * @param $item
     */
    private function CheckBidPosted($veilingOpen, $itemModel, $bod, $item) {
        if (isset($_POST["btnSubmit"])) {
            $input = filter_input(INPUT_POST, 'inputBod', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);
            if (isset($input) && $veilingOpen && Authorization::IsLoggedIn()) {
                $this->insertBod($itemModel, $bod, $item, $input);
            }
        }
    }

    /**
     * Calculeer hoelang het product van begin dag tot eind dag blijft bestaan.
     * @param $beginDag
     * @param $eindDag
     * @param $beginTijdstip
     * @param $eindTijdstip
     * @return string
     */
    private function calculateLooptijd($beginDag, $eindDag, $beginTijdstip, $eindTijdstip) {
        $date1 = date_create($beginDag . $beginTijdstip);
        $date2 = date_create($eindDag . $eindTijdstip);
        $diff = date_diff($date1, $date2);
        return $diff->format('%d dagen, %h uren en %i minuten.');
    }

    /**
     * Bieding checks
     * @param $bod
     * @param $input
     * @return bool
     */
    private function UserBidIsValid($bod, $input, $item) : bool {
        if (empty($bod)) $hoogsteBod = 0;
        else $hoogsteBod = $bod[0]['Bodbedrag'];
        return ($input > $hoogsteBod && $input > $item['Startprijs'] && $input != $hoogsteBod && $input < 999999 && $input > 0);
    }

    /**
     * Om een bod in te voegen.
     * @param $model
     * @param $bod
     * @param $item
     * @param $input
     */
    private function insertBod($model, $bod, $item, $input) {
        $input = str_replace(',', '.', $input);

        // als het bod valid is voegen we hem toe en refreshen we de pagina.
        if ($this->UserBidIsValid($bod, $input, $item)) {
            $model->insertBod($input, date("Y-m-d"), $_SESSION['Gebruikersnaam'], date("H:i:s"), $item['Voorwerpnummer']);
            header('Location: /Voorwerp/Pagina/'.$item["Voorwerpnummer"].'?success=Success');
        } else {
            header('Location: /Voorwerp/Pagina/'.$item["Voorwerpnummer"].'?error=OngeldigeInvoer');
        }

        die;
    }

    /**
     * Bekijk of de datum van het voorwerp aanbod verlopen is.
     * @param $model
     * @param $item
     * @return bool
     * @throws Exception
     */
    private function IsActionBiddable($model, $item) : bool {
        $currentDay = new DateTime(date("Y-m-d"));
        $currentTime = new DateTime(date("H:i:s"));
        $eindeLoopdag = new DateTime($item['LooptijdeindeDag']);
        $eindeTijdstip = new DateTime($item["LooptijdEindeTijdstip"]);

        if (($currentDay == $eindeLoopdag && $eindeTijdstip < $currentTime) || $currentDay > $eindeLoopdag) {
            $model->sluitVeiling($item['Voorwerpnummer']);
            return false;
        }

        return true;
    }
}
